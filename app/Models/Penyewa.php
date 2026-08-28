<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penyewa extends Model
{
    protected $table = 'tenants';

    public $timestamps = false;

    protected $fillable = [
        'fullname',
        'status_customer',
        'jenis_perusahaan',
        'brand',
        'created_at',
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(KaiContract::class, 'tenant_id');
    }
}
