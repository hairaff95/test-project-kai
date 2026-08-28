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
    public $incrementing  = false;
    protected $keyType    = 'string';

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
        'keterangan',
        'created_at',
    ];

    protected $casts = [
        'contract_date'       => 'date',
        'start_datetime'      => 'date',
        'end_datetime'        => 'date',
        'start_datetime_baru' => 'date',
        'end_datetime_baru'   => 'date',
        'price'               => 'decimal:2',
        'created_at'          => 'datetime',
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
        $end  = $this->end_datetime_baru ?? $this->end_datetime;
        if (!$end) return '-';

        $diff = now()->diffInDays($end, false);

        if ($diff < 0) return 'Sudah berakhir';
        if ($diff === 0) return 'Hari ini';

        $months = (int) ($diff / 30);
        $days   = $diff % 30;

        if ($months > 0) {
            return $months . ' bulan' . ($days > 0 ? ' ' . $days . ' hari' : '');
        }
        return $diff . ' hari';
    }
}
