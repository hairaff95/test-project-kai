<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetImage extends Model
{
    protected $fillable = ['asset_id', 'image_path', 'caption', 'is_primary'];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        return asset('storage/' . $this->image_path);
    }
}
