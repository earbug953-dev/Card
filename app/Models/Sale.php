<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'plan_id', 'membership_card_id',
        'amount', 'payment_method', 'payment_status',
        'reference', 'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
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

    public function membershipCard()
    {
        return $this->belongsTo(MembershipCard::class);
    }

    // ─── Scopes ─────────────────────────────────────────────
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    // ─── Accessors ──────────────────────────────────────────
    public function getReceiptNumberAttribute(): string
    {
        return 'RCP-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
