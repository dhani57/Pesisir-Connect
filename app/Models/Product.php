<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'price_unit',
        'location',
        'address',
        'latitude',
        'longitude',
        'thumbnail',
        'gallery',
        'capacity',
        'facilities',
        'whatsapp',
        'rating',
        'total_reviews',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price'         => 'decimal:2',
            'latitude'      => 'decimal:8',
            'longitude'     => 'decimal:8',
            'rating'        => 'decimal:2',
            'gallery'       => 'array',
            'facilities'    => 'array',
            'is_featured'   => 'boolean',
            'is_active'     => 'boolean',
        ];
    }

    // ──────────────────────────────────────────
    // Boot
    // ──────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    /** Vendor who owns this product. */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Category this product belongs to. */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** Transactions for this product. */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', $location);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────

    /** Formatted price in Rupiah. */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /** WhatsApp direct link. */
    public function getWhatsappLinkAttribute(): string
    {
        $phone = preg_replace('/[^0-9]/', '', $this->whatsapp ?? '');

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $message = urlencode("Halo, saya tertarik dengan {$this->name} di PesisirConnect. Apakah masih tersedia?");

        return "https://wa.me/{$phone}?text={$message}";
    }

    /** Thumbnail URL with fallback. */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && file_exists(public_path($this->thumbnail))) {
            return asset($this->thumbnail);
        }

        return asset('images/products/placeholder.png');
    }
}
