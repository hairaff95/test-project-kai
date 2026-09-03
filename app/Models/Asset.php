<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_code',
        'name',
        'district_area',
        'full_address',
        'description',
        'land_area',
        'building_area',
        'price',
        'road_access',
        'electricity',
        'water_supply',
        'security',
        'contact_person',
        'contact_phone',
        'latitude',
        'longitude',
        'status',
        'created_by',
    ];

    protected $casts = [
        'land_area'     => 'float',
        'building_area' => 'float',
        'price'         => 'float',
        'latitude'      => 'float',
        'longitude'     => 'float',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(AssetImage::class);
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(AssetImage::class)->where('is_primary', true);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByDistrict($query, string $district)
    {
        return $query->where('district_area', $district);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function getPriceFormattedAttribute(): string
    {
        $billions = $this->price / 1_000_000_000;
        $millions = $this->price / 1_000_000;

        if ($billions >= 1) {
            return 'Rp ' . number_format($billions, 2) . ' M';
        }

        return 'Rp ' . number_format($millions, 2) . ' Jt';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'TERSEDIA',
            'reserved'  => 'DALAM PROSES',
            'sold'      => 'TERJUAL',
            default     => strtoupper($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'available' => '#006948',
            'reserved'  => '#d97706',
            'sold'      => '#6b7280',
            default     => '#006948',
        };
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->where('is_primary', true)->first()
                ?? $this->images->first();

        if (!$primary) {
            return 'https://images.unsplash.com/photo-1486325212027-8081e485255e?auto=format&fit=crop&w=800&q=80';
        }

        if (str_starts_with($primary->image_path, 'http')) {
            return $primary->image_path;
        }

        return asset('storage/' . $primary->image_path);
    }
}
