<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'description',
        'short_description',
        'price',
        'discount',
        'discount_type',
        'price_unit',
        'location',
        'address',
        'latitude',
        'longitude',
        'thumbnail',
        'gallery',
        'capacity',
        'stock',
        'facilities',
        'whatsapp',
        'rating',
        'total_reviews',
        'is_featured',
        'is_active',
        'status',
        'min_stock_alert',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price'         => 'decimal:2',
            'latitude'      => 'decimal:8',
            'longitude'     => 'decimal:8',
            'rating'        => 'decimal:2',
            'discount'      => 'decimal:2',
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

    /** User who owns this product. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Vendor who owns this product. */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
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

    /** Reviews for this product (through transactions). */
    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(
            VendorReview::class,
            Transaction::class,
            'product_id',      // Foreign key on transactions table
            'transaction_id',  // Foreign key on vendor_reviews table
            'id',              // Local key on products table
            'id'               // Local key on transactions table
        );
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('products.is_active', true)
                     ->whereHas('vendor', function ($q) {
                         $q->where('is_approved', true)
                           ->where('status', 'approved');
                     });
    }

    public function scopeByVendor($query, int $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'active');
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

    /** Discounted price calculation. */
    public function getDiscountedPriceAttribute(): float
    {
        if ($this->discount <= 0) return (float) $this->price;

        if ($this->discount_type === 'percentage') {
            return (float) $this->price * (1 - $this->discount / 100);
        }

        return max(0, (float) $this->price - (float) $this->discount);
    }

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

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail && str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        if ($this->thumbnail && file_exists(public_path($this->thumbnail))) {
            return asset($this->thumbnail);
        }

        return 'https://placehold.co/800x600/0ea5e9/ffffff?text=PesisirConnect';
    }
}
