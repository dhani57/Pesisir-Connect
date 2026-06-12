<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'location',
        'tagline',
        'description',
        'highlights',
        'rating',
        'reviews_count',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'highlights'    => 'array',
            'rating'        => 'decimal:1',
            'reviews_count' => 'integer',
            'sort_order'    => 'integer',
            'is_active'     => 'boolean',
        ];
    }

    // ──────────────────────────────────────────
    // Boot
    // ──────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Destination $destination) {
            if (empty($destination->slug)) {
                $destination->slug = Str::slug($destination->name);
            }
        });
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────

    /** Get image URL with fallback. */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        if ($this->image && str_starts_with($this->image, '/storage/')) {
            return asset($this->image);
        }

        if ($this->image && file_exists(public_path('images/' . $this->image))) {
            return asset('images/' . $this->image);
        }

        return 'https://placehold.co/800x600/0ea5e9/ffffff?text=' . urlencode($this->name);
    }
}
