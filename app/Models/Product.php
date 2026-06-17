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
        'gmaps_link',
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
            $product->extractCoordsFromGmapsLink();
        });

        static::updating(function (Product $product) {
            $product->extractCoordsFromGmapsLink();
        });
    }

    public function extractCoordsFromGmapsLink(): void
    {
        if (!empty($this->gmaps_link)) {
            $coords = self::parseGoogleMapsLink($this->gmaps_link);
            if ($coords) {
                $this->latitude = $coords['latitude'];
                $this->longitude = $coords['longitude'];
            }
        }
    }

    public static function parseGoogleMapsLink(string $url): ?array
    {
        // If it's a shortened URL (goo.gl or maps.app.goo.gl), resolve the redirect first
        if (preg_match('/(maps\.app\.goo\.gl|goo\.gl\/maps)/i', $url)) {
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                $response = curl_exec($ch);
                $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                curl_close($ch);
                if ($finalUrl) {
                    $url = $finalUrl;
                }
            } catch (\Exception $e) {
                // Ignore error and try parsing original URL
            }
        }

        // 1. Try matching @lat,lng (most common in web URLs)
        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            return [
                'latitude' => $matches[1],
                'longitude' => $matches[2]
            ];
        }

        // 2. Try matching query parameter q=lat,lng or daddr=lat,lng
        if (preg_match('/[?&](q|daddr|query)=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            return [
                'latitude' => $matches[2],
                'longitude' => $matches[3]
            ];
        }

        // 3. Try matching in path /maps/place/lat,lng
        if (preg_match('/\/maps\/place\/(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            return [
                'latitude' => $matches[1],
                'longitude' => $matches[2]
            ];
        }

        // 4. Fallback: Resolve via Google Maps Embed API using extracted place name/address
        $placeQuery = null;
        if (preg_match('/\/maps\/place\/([^\/]+)/', $url, $matches)) {
            $placeQuery = $matches[1];
        } elseif (preg_match('/[?&](q|query)=([^&]+)/', $url, $matches)) {
            $placeQuery = $matches[2];
        }

        if ($placeQuery) {
            // Strip coordinates or zoom level if present in the place name segment (e.g. split by @)
            if (strpos($placeQuery, '@') !== false) {
                $parts = explode('@', $placeQuery);
                $placeQuery = $parts[0];
            }
            $placeQuery = trim(urldecode(str_replace('+', ' ', $placeQuery)), '/, ');

            if (!empty($placeQuery)) {
                try {
                    $embedUrl = "https://maps.google.com/maps?q=" . urlencode($placeQuery) . "&output=embed";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $embedUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
                    $html = curl_exec($ch);
                    curl_close($ch);

                    if ($html && preg_match('/\[\[\[\d+(?:\.\d+)?\s*,\s*(-?\d+\.\d+)\s*,\s*(-?\d+\.\d+)\]/', $html, $matches)) {
                        return [
                            'latitude' => $matches[2],
                            'longitude' => $matches[1]
                        ];
                    }
                } catch (\Exception $e) {
                    // Ignore error
                }
            }
        }

        return null;
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

    /** Array of gallery image URLs. */
    public function getGalleryUrlsAttribute(): array
    {
        $urls = [];
        if ($this->gallery && is_array($this->gallery)) {
            foreach ($this->gallery as $image) {
                if ($image) {
                    if (str_starts_with($image, 'http')) {
                        $urls[] = $image;
                    } elseif (file_exists(public_path($image))) {
                        $urls[] = asset($image);
                    } elseif (file_exists(public_path('storage/' . $image))) {
                        $urls[] = asset('storage/' . $image);
                    } else {
                        $urls[] = asset($image);
                    }
                }
            }
        }
        return $urls;
    }
}
