<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KaiAsset extends Model
{
    protected $table = 'assets';

    // Primary key adalah string, bukan auto-increment integer
    protected $primaryKey = 'asset_number';
    public $incrementing  = false;
    protected $keyType    = 'string';

    public $timestamps = false;

    protected $fillable = [
        'asset_number',
        'asset_block_name',
        'size_area',
        'peruntukan',
        'jenis_aset',
        'stasiun',
        'wilayah_aset',
        'latitude',
        'longitude',
        'created_at',
    ];

    protected $casts = [
        'size_area'  => 'decimal:2',
        'latitude'   => 'decimal:8',
        'longitude'  => 'decimal:8',
        'created_at' => 'datetime',
    ];

    public function contract(): HasOne
    {
        return $this->hasOne(KaiContract::class, 'asset_number', 'asset_number');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(KaiContract::class, 'asset_number', 'asset_number');
    }

    // Accessor: format luas area
    public function getSizeAreaFormattedAttribute(): string
    {
        return number_format((float) $this->size_area, 2, ',', '.') . ' m²';
    }
}
