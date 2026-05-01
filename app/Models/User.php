<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','is_admin',
        'user_photo','phone','address',
    ];

    protected $hidden = ['password','remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_admin'          => 'boolean',
    ];

    public function purchaseTransactions() {
        return $this->hasMany(PurchaseTransaction::class);
    }

    public function chatConversations() {
        return $this->hasMany(ChatConversation::class);
    }
}
