<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'product_id',
        'vendor_id',
        'check_in',
        'check_out',
        'quantity',
        'guests',
        'unit_price',
        'total_price',
        'status',
        'vendor_status',
        'payment_method',
        'snap_token',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'midtrans_response',
        'paid_at',
        'completed_at',
        'notes',
        'vendor_notes',
    ];

    protected function casts(): array
    {
        return [
            'check_in'          => 'date',
            'check_out'         => 'date',
            'unit_price'        => 'decimal:2',
            'total_price'       => 'decimal:2',
            'midtrans_response' => 'array',
            'paid_at'           => 'datetime',
            'completed_at'      => 'datetime',
        ];
    }

    // ──────────────────────────────────────────
    // Boot
    // ──────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (Transaction $trx) {
            if (empty($trx->invoice_number)) {
                $trx->invoice_number = 'PC-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            }
        });
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    /** Customer who made this transaction. */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Vendor for this transaction. */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /** Product being booked. */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** Review left for this transaction. */
    public function review(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(VendorReview::class);
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────

    /** Formatted total in Rupiah. */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /** Duration in nights/days. */
    public function getDurationAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }
}
