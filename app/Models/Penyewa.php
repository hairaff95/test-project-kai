<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyewa extends Model
{
    protected $table = 'penyewa';

    public $timestamps = false;

    protected $fillable = [
        'fullnama',
        'status_pelanggan',
        'jenis_perusahaan',
        'merek',
        'dibuat_pada',
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }
}
