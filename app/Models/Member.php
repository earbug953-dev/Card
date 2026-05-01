<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'date_of_birth',
        'gender', 'address', 'notes', 'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    // ─── Relationships ──────────────────────────────────────
    public function membershipCards()
    {
        return $this->hasMany(MembershipCard::class);
    }

    public function activeCard()
    {
        return $this->hasOne(MembershipCard::class)
                    ->where('status', 'active')
                    ->latest();
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // ─── Scopes ─────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // ─── Accessors ──────────────────────────────────────────
    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', $this->name);
        return strtoupper(
            count($parts) >= 2
                ? $parts[0][0] . $parts[1][0]
                : $parts[0][0]
        );
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }
}
