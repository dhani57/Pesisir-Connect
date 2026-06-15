<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_type',
        'body',
        'attachment',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    /** Conversation this message belongs to. */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /** User who sent this message. */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    /** Check if this message has been read. */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    /** Check if the message was sent by a given user. */
    public function isSentBy(int $userId): bool
    {
        return $this->sender_id === $userId;
    }

    /** Get formatted timestamp. */
    public function getFormattedTimeAttribute(): string
    {
        $now = now();
        $created = $this->created_at;

        if ($created->isToday()) {
            return $created->format('H:i');
        }

        if ($created->isYesterday()) {
            return 'Kemarin, ' . $created->format('H:i');
        }

        if ($created->year === $now->year) {
            return $created->translatedFormat('d M, H:i');
        }

        return $created->translatedFormat('d M Y, H:i');
    }
}
