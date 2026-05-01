<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'plan_id', 'purchase_transaction_id', 'card_number',
        'issue_date', 'expiry_date', 'status',
    ];

    protected $casts = [
        'issue_date'  => 'date',
        'expiry_date' => 'date',
    ];

    // ─── Relationships ──────────────────────────────────────
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }

    // ─── Scopes ─────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->where('status', 'active')
                     ->whereBetween('expiry_date', [now(), now()->addDays($days)]);
    }

    // ─── Accessors ──────────────────────────────────────────
    public function getFormattedNumberAttribute(): string
    {
        return implode(' ', str_split($this->card_number, 4));
    }

    public function getDaysUntilExpiryAttribute(): ?int
    {
        return $this->expiry_date?->diffInDays(now(), false) * -1;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date?->isPast() ?? false;
    }
}
