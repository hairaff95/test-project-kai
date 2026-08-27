<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractFinancial extends Model
{
    protected $table = 'contract_financials';

    public $timestamps = false;

    protected $fillable = [
        'contract_number',
        'jumlah_hari',
        'nilai_per_hari',
        'awal',
        'akhir',
        'hari_2026',
        'nilai_2026',
        'nilai_backlog',
        'nilai_backlog2',
        'gl_account',
        'form_rka',
        'tahun_rka',
        'jenis_pendapatan',
        'persentase',
        'pencapaian',
        'ket',
    ];

    protected $casts = [
        'awal'           => 'date',
        'akhir'          => 'date',
        'nilai_per_hari' => 'decimal:2',
        'nilai_2026'     => 'decimal:2',
        'nilai_backlog'  => 'decimal:2',
        'nilai_backlog2' => 'decimal:2',
        'persentase'     => 'decimal:2',
        'pencapaian'     => 'decimal:2',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(KaiContract::class, 'contract_number', 'contract_number');
    }
}
