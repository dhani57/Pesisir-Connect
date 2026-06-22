<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'business_type',
        'phone',
        'address',
        'city',
        'zip_code',
        'bank_name',
        'account_holder',
        'account_number',
        'logo',
        'avatar',
        'bio',
        'business_license',
        'status',
        'is_approved',
        'verified_at',
        'commission_rate',
        'total_earnings',
        'response_time_hours',
        'auto_approve_orders',
        'enable_notifications',
        'notification_channels',
    ];

    protected function casts(): array
    {
        return [
            'is_approved'           => 'boolean',
            'auto_approve_orders'   => 'boolean',
            'enable_notifications'  => 'boolean',
            'verified_at'           => 'datetime',
            'commission_rate'       => 'decimal:2',
            'total_earnings'        => 'decimal:2',
            'notification_channels' => 'array',
        ];
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    /** User account associated with this vendor. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Products belonging to this vendor. */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /** Transactions for this vendor's products. */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /** Commission logs. */
    public function commissionLogs(): HasMany
    {
        return $this->hasMany(VendorCommissionLog::class);
    }

    /** Payouts received. */
    public function payouts(): HasMany
    {
        return $this->hasMany(VendorPayout::class);
    }

    /** Reviews received from customers. */
    public function reviews(): HasMany
    {
        return $this->hasMany(VendorReview::class);
    }

    /** Notifications. */
    public function notifications(): HasMany
    {
        return $this->hasMany(VendorNotification::class);
    }

    /** Conversations with customers. */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true)->where('status', 'approved');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('status', 'pending_approval');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved')->where('is_approved', true);
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────

    /** Get effective commission rate. */
    public function getEffectiveCommissionRateAttribute(): float
    {
        return $this->commission_rate > 0 ? (float) $this->commission_rate : (float) setting('platform_commission', 5);
    }

    /** Get formatted total earnings. */
    public function getFormattedEarningsAttribute(): string
    {
        return 'Rp ' . number_format($this->total_earnings, 0, ',', '.');
    }

    /** Get average rating from reviews. */
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->where('is_hidden', false)->avg('rating') ?? 0, 1);
    }

    /** Get total reviews count. */
    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->where('is_hidden', false)->count();
    }

    /** Get unread notifications count. */
    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    /** Get unread messages count. */
    public function getUnreadMessagesCountAttribute(): int
    {
        $userId = $this->user_id;
        return \App\Models\Message::whereHas('conversation', function ($query) {
            $query->where('vendor_id', $this->id);
        })
        ->where('sender_id', '!=', $userId)
        ->whereNull('read_at')
        ->count();
    }

    /** Get logo URL. */
    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }

        if ($this->logo && file_exists(public_path($this->logo))) {
            return asset($this->logo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->shop_name) . '&background=0ea5e9&color=fff&size=128';
    }

    /** Get avatar URL. */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }

        if ($this->avatar && file_exists(public_path($this->avatar))) {
            return asset($this->avatar);
        }

        return $this->logo_url;
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    /** Check if vendor is approved and active. */
    public function isActive(): bool
    {
        return $this->is_approved && $this->status === 'approved';
    }

    /** Check if vendor is pending approval. */
    public function isPending(): bool
    {
        return $this->status === 'pending_approval';
    }

    /** Check if vendor is suspended. */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /** Get status badge color. */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'approved'         => 'green',
            'pending_approval' => 'yellow',
            'suspended'        => 'red',
            'deactivated'      => 'gray',
            default            => 'gray',
        };
    }

    /** Get status label. */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'approved'         => 'Disetujui',
            'pending_approval' => 'Menunggu Persetujuan',
            'suspended'        => 'Ditangguhkan',
            'deactivated'      => 'Nonaktif',
            default            => $this->status,
        };
    }
}
