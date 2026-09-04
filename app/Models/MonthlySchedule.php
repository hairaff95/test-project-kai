<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlySchedule extends Model
{
    protected $table = 'monthly_schedules';

    public $timestamps = false;

    protected $fillable = [
        'contract_number',
        'tahun',
        'invoice',
        'januari', 'febuari', 'maret', 'april',
        'mei', 'juni', 'juli', 'agustus',
        'september', 'oktober', 'november', 'desember',
        'jan_des',
    ];

    protected $casts = [
        'januari'   => 'float',
        'febuari'   => 'float',
        'maret'     => 'float',
        'april'     => 'float',
        'mei'       => 'float',
        'juni'      => 'float',
        'juli'      => 'float',
        'agustus'   => 'float',
        'september' => 'float',
        'oktober'   => 'float',
        'november'  => 'float',
        'desember'  => 'float',
        'jan_des'   => 'float',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(KaiContract::class, 'contract_number', 'contract_number');
    }

    // Ambil nilai bulan berdasarkan nama bulan (1-12)
    public function getMonthValue(int $month): float
    {
        $map = [
            1  => 'januari',  2  => 'febuari',  3  => 'maret',
            4  => 'april',    5  => 'mei',       6  => 'juni',
            7  => 'juli',     8  => 'agustus',   9  => 'september',
            10 => 'oktober',  11 => 'november',  12 => 'desember',
        ];
        $col = $map[$month] ?? null;
        return $col ? (float) $this->$col : 0;
    }
}
