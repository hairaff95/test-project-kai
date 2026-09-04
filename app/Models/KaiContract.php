<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KaiContract extends Model
{
    protected $table = 'contracts';

    protected $primaryKey = 'contract_number';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'contract_number',
        'tenant_id',
        'asset_number',
        'contract_date',
        'jenis_kontrak',
        'area_kontrak',
        'start_datetime',
        'end_datetime',
        'start_datetime_baru',
        'end_datetime_baru',
        'price',
        'spv',
        'asset_block_name',
        'size_area',
        'peruntukan',
        'keterangan',
        'created_at',
    ];

    protected $casts = [
        'start_datetime' => 'date',
        'end_datetime' => 'date',
        'start_datetime_baru' => 'date',
        'end_datetime_baru' => 'date',
        'price' => 'float',
        'size_area' => 'float',
        'created_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Penyewa::class, 'tenant_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(KaiAsset::class, 'asset_number', 'asset_number');
    }

    public function financial(): HasOne
    {
        return $this->hasOne(ContractFinancial::class, 'contract_number', 'contract_number');
    }

    public function monthlySchedules(): HasMany
    {
        return $this->hasMany(MonthlySchedule::class, 'contract_number', 'contract_number');
    }

    // Accessor harga format rupiah
    public function getPriceFormattedAttribute(): string
    {
        $val = (float) $this->price;
        if ($val >= 1_000_000_000) {
            return 'Rp ' . number_format($val / 1_000_000_000, 2, ',', '.') . ' M';
        }
        return 'Rp ' . number_format($val, 0, ',', '.');
    }

    // Hitung sisa hari kontrak dari end_datetime_baru
    public function getDueDaysAttribute(): string
    {
        $end = $this->end_datetime_baru ?? $this->end_datetime;
        if (!$end)
            return '-';

        $endCarbon = $end instanceof \Carbon\CarbonInterface ? $end : \Carbon\Carbon::parse((string) $end);
        $today = now()->startOfDay();
        $endDay = $endCarbon->copy()->startOfDay();

        if ($endDay->lt($today))
            return 'Sudah berakhir';
        if ($endDay->eq($today))
            return 'Hari ini';

        $months = (int) $today->diffInMonths($endDay);
        $days   = (int) $today->copy()->addMonths($months)->diffInDays($endDay);

        if ($months > 0) {
            return $months . ' bulan' . ($days > 0 ? ' ' . $days . ' hari' : '');
        }
        return $days . ' hari';
    }

    // Accessor: format luas area (e.g. 42 m², 43,5 m²)
    public function getSizeAreaFormattedAttribute(): string
    {
        if ($this->size_area === null)
            return '-';
        $formatted = number_format((float) $this->size_area, 2, ',', '.');
        $trimmed = rtrim(rtrim($formatted, '0'), ',');
        return $trimmed . ' m²';
    }

    // Accessor: format nomor kontrak bersih tanpa suffix angka duplikat (e.g. "KL.701/IX/41/DO.4-2024 (7)" -> "KL.701/IX/41/DO.4-2024")
    public function getCleanContractNumberAttribute(): string
    {
        if (!$this->contract_number) return '-';
        return preg_replace('/\s*\(\d+\)$/', '', (string) $this->contract_number);
    }
}
