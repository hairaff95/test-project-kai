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
        'sub_title',
        'description',
        'size_area',
        'peruntukan',
        'jenis_asset',
        'stasiun',
        'wilayah_asset',
        'latitude',
        'longitude',
        'created_at',
    ];

    protected $casts = [
        'size_area'  => 'float',
        'latitude'   => 'float',
        'longitude'  => 'float',
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

    public function images(): HasMany
    {
        return $this->hasMany(\App\Models\AssetImage::class, 'asset_id', 'asset_number');
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        // Guard: relasi images bisa saja belum di-load atau kolom lama bernilai string
        $imgs = ($this->relationLoaded('images') && $this->getRelation('images') instanceof \Illuminate\Support\Collection)
            ? $this->getRelation('images')
            : collect();

        $primary = $imgs->where('is_primary', true)->first() ?? $imgs->first();

        if (!$primary) {
            return asset('images/placeholder.png');
        }

        if (str_starts_with($primary->image_path, 'http')) {
            return $primary->image_path;
        }

        return asset('storage/' . $primary->image_path);
    }

    // Accessor: format luas area
    public function getSizeAreaFormattedAttribute(): string
    {
        if ($this->size_area === null) return '-';
        $formatted = number_format((float) $this->size_area, 2, ',', '.');
        $trimmed = rtrim(rtrim($formatted, '0'), ',');
        return $trimmed . ' m²';
    }
}
