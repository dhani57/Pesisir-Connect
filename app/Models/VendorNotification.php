<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'type',
        'title',
        'message',
        'action_url',
        'data',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
            'data'    => 'array',
        ];
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    /** Mark this notification as read. */
    public function markAsRead(): void
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /** Get icon based on notification type. */
    public function getIconAttribute(): string
    {
        return match ($this->type) {
            'order_received'   => '🛒',
            'payment_received' => '💰',
            'new_review'       => '⭐',
            'stock_alert'      => '📦',
            'payout_processed' => '🏦',
            'admin_message'    => '📢',
            'approval_status'  => '✅',
            default            => '🔔',
        };
    }

    /** Get notification type label. */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'order_received'   => 'Pesanan Baru',
            'payment_received' => 'Pembayaran Diterima',
            'new_review'       => 'Ulasan Baru',
            'stock_alert'      => 'Peringatan Stok',
            'payout_processed' => 'Pembayaran Diproses',
            'admin_message'    => 'Pesan Admin',
            'approval_status'  => 'Status Persetujuan',
            default            => 'Notifikasi',
        };
    }

    /**
     * Create a notification for a vendor.
     */
    public static function send(int $vendorId, string $type, string $title, string $message, ?string $actionUrl = null, ?array $data = null): self
    {
        return static::create([
            'vendor_id'  => $vendorId,
            'type'       => $type,
            'title'      => $title,
            'message'    => $message,
            'action_url' => $actionUrl,
            'data'       => $data,
        ]);
    }
}
