<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorCommissionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'transaction_id',
        'amount',
        'commission_percentage',
        'commission_amount',
        'vendor_earning',
        'period_start',
        'period_end',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'                => 'decimal:2',
            'commission_percentage' => 'decimal:2',
            'commission_amount'     => 'decimal:2',
            'vendor_earning'        => 'decimal:2',
            'period_start'          => 'date',
            'period_end'            => 'date',
            'paid_at'               => 'datetime',
        ];
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // ──────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'calculated');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────

    public function getFormattedEarningAttribute(): string
    {
        return 'Rp ' . number_format($this->vendor_earning, 0, ',', '.');
    }

    public function getFormattedCommissionAttribute(): string
    {
        return 'Rp ' . number_format($this->commission_amount, 0, ',', '.');
    }
}
