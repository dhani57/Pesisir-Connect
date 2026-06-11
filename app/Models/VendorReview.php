<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'user_id',
        'transaction_id',
        'rating',
        'review_text',
        'helpful_count',
        'is_hidden',
        'vendor_reply',
        'vendor_reply_at',
    ];

    protected function casts(): array
    {
        return [
            'rating'          => 'integer',
            'helpful_count'   => 'integer',
            'is_hidden'       => 'boolean',
            'vendor_reply_at' => 'datetime',
        ];
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────

    /** Get star icons HTML. */
    public function getStarsHtmlAttribute(): string
    {
        $filled = str_repeat('★', $this->rating);
        $empty  = str_repeat('☆', 5 - $this->rating);
        return $filled . $empty;
    }

    /** Check if vendor has replied. */
    public function hasReply(): bool
    {
        return !empty($this->vendor_reply);
    }
}
