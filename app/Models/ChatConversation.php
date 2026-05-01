<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_transaction_id', 'user_id', 'admin_id', 'status',
    ];

    protected $casts = [];

    // ─── Relationships ──────────────────────────────────────
    public function purchaseTransaction()
    {
        return $this->belongsTo(PurchaseTransaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    // ─── Scopes ─────────────────────────────────────────────
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // ─── Methods ────────────────────────────────────────────
    public function close()
    {
        $this->update(['status' => 'closed']);
    }
}
