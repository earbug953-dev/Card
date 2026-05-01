<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Plan extends Model {
    use HasFactory;
    protected $fillable = ['name','description','price','duration_months','color','features','is_active','celebrity_name','celebrity_image'];
    protected $casts = ['price'=>'decimal:2','is_active'=>'boolean'];
    public function membershipCards(){return $this->hasMany(MembershipCard::class);}
    public function memberships(){return $this->hasMany(MembershipCard::class)->where('status','active');}
    public function purchaseTransactions(){return $this->hasMany(PurchaseTransaction::class);}
    public function sales(){return $this->hasMany(Sale::class);}
    public function scopeActive($query){return $query->where('is_active',true);}
    public function getFeaturesListAttribute():array{if(!$this->features)return[];return array_filter(array_map('trim',explode("\n",$this->features)));}
}
