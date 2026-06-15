<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active', 'phone', 'avatar', 'bio', 'address'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    /** Products owned by this vendor. */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /** Vendor profile (if user is a vendor). */
    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    /** Transactions made by this customer. */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /** Reviews written by this customer. */
    public function reviews(): HasMany
    {
        return $this->hasMany(VendorReview::class);
    }

    /** Conversations where this user is the customer. */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'customer_id');
    }

    /** Messages sent by this user. */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // ──────────────────────────────────────────
    // Role Helpers
    // ──────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isVendor(): bool
    {
        return $this->role === 'vendor';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // ──────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────

    /** Get avatar URL with fallback to UI Avatars. */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }

        if ($this->avatar && file_exists(public_path($this->avatar))) {
            return asset($this->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0ea5e9&color=fff&size=128';
    }

    /** Get total unread chat messages count. */
    public function getUnreadMessagesCountAttribute(): int
    {
        return Message::where('sender_id', '!=', $this->id)
            ->whereNull('read_at')
            ->whereHas('conversation', fn ($q) => $q->where('customer_id', $this->id))
            ->count();
    }

    // ──────────────────────────────────────────
    // Filament
    // ──────────────────────────────────────────
    
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin() && $this->is_active;
        }

        return false;
    }
}
