<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'vendor_id',
        'product_id',
        'subject',
        'last_message_at',
        'is_archived_customer',
        'is_archived_vendor',
    ];

    protected function casts(): array
    {
        return [
            'last_message_at'      => 'datetime',
            'is_archived_customer' => 'boolean',
            'is_archived_vendor'   => 'boolean',
        ];
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    /** Customer (user) in this conversation. */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /** Vendor in this conversation. */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /** Product related to this conversation (optional). */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** All messages in this conversation. */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /** Latest message preview. */
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    /** Conversations involving a specific customer. */
    public function scopeForCustomer($query, int $customerId)
    {
        return $query->where('customer_id', $customerId)
                     ->where('is_archived_customer', false);
    }

    /** Conversations involving a specific vendor. */
    public function scopeForVendor($query, int $vendorId)
    {
        return $query->where('vendor_id', $vendorId)
                     ->where('is_archived_vendor', false);
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    /** Get count of unread messages for a given user. */
    public function unreadCountFor(int $userId): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }

    /** Mark all messages as read for a given user. */
    public function markAsReadFor(int $userId): void
    {
        $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /** Get the other participant's name relative to the user. */
    public function getOtherParticipantName(int $userId): string
    {
        if ($this->customer_id === $userId) {
            return $this->vendor?->shop_name ?? 'Vendor';
        }

        return $this->customer?->name ?? 'Customer';
    }

    /** Get the other participant's avatar URL relative to the user. */
    public function getOtherParticipantAvatar(int $userId): string
    {
        if ($this->customer_id === $userId) {
            return $this->vendor?->avatar_url ?? '';
        }

        $customer = $this->customer;
        if ($customer?->avatar && file_exists(public_path($customer->avatar))) {
            return asset($customer->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($customer?->name ?? 'U') . '&background=0ea5e9&color=fff&size=64';
    }
}
