<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class PurchaseTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan_id', 'amount', 'status',
        'access_code', 'payment_notes', 'approved_by', 'approved_at',
    ];

    protected $casts = [
        'amount'      => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    // ─── Relationships ──────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function chatConversation()
    {
        return $this->hasOne(ChatConversation::class);
    }

    public function membershipCard()
    {
        return $this->hasOne(MembershipCard::class);
    }

    protected function resolveMember(): Member
    {
        $user = $this->user;

        return Member::firstOrCreate([
            'email' => $user->email,
        ], [
            'name'  => $user->name,
            'phone' => $this->user_phone ?? $user->phone,
            'address' => $this->user_address ?? $user->address,
            'status' => 'active',
        ]);
    }

    // ─── Scopes ─────────────────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // ─── Methods ────────────────────────────────────────────
    public function generateAccessCode()
    {
        do {
            $code = 'VIP-' . strtoupper(bin2hex(random_bytes(3)));
        } while (self::where('access_code', $code)->exists());

        $this->update(['access_code' => $code]);
        return $code;
    }

    public function approve($approverUserId, $notes = null)
    {
        $this->update([
            'status'       => 'approved',
            'approved_by'  => $approverUserId,
            'approved_at'  => now(),
            'payment_notes' => $notes ?? $this->payment_notes,
        ]);
    }

    public function reject($notes = null)
    {
        $this->update([
            'status'        => 'rejected',
            'payment_notes' => $notes ?? $this->payment_notes,
        ]);
    }

    public function complete()
    {
        if ($this->membershipCard) {
            return $this->membershipCard;
        }

        // Generate access code if not already done
        if (!$this->access_code) {
            $this->generateAccessCode();
        }

        $member = $this->resolveMember();

        // Create membership card
        $membershipCard = MembershipCard::create([
            'member_id'               => $member->id,
            'plan_id'                 => $this->plan_id,
            'purchase_transaction_id' => $this->id,
            'card_number'             => strtoupper(bin2hex(random_bytes(8))),
            'issue_date'              => now(),
            'expiry_date'             => now()->addMonths($this->plan->duration_months),
            'status'                  => 'active',
        ]);

        $this->update(['status' => 'completed']);
        return $membershipCard;
    }
}
