<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Member;
use App\Models\Plan;
use App\Models\MembershipCard;
use App\Models\Sale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Admin user
        User::firstOrCreate(['email'=>'admin@demo.com'],[
            'name'=>'Admin User','password'=>Hash::make('password'),'is_admin'=>true,
        ]);
        // Demo fan user
        User::firstOrCreate(['email'=>'fan@demo.com'],[
            'name'=>'Donna McAbee','password'=>Hash::make('password'),'is_admin'=>false,
            'phone'=>'+1 864-555-0199','address'=>'SC, Spartanburg, 1424 Denton Rd',
        ]);

        $plans = [
            ['name'=>'Bronze','description'=>'Entry-level fan membership','price'=>99,'duration_months'=>1,'color'=>'bronze','celebrity_name'=>'MORGAN WALLEN','celebrity_image'=>null,'features'=>"Official VIP Membership Card\n1-Month Full Access\nMember Portal Access\nBasic Member Support\nExclusive Digital Card"],
            ['name'=>'Silver','description'=>'Popular choice for dedicated fans','price'=>149,'duration_months'=>6,'color'=>'silver','celebrity_name'=>'MORGAN WALLEN','celebrity_image'=>null,'features'=>"All Bronze Benefits\n6-Month Access\nPriority Support\nExclusive Events\nMember Discounts\nFree Card Replacement"],
            ['name'=>'Gold','description'=>'Premium VIP fan experience','price'=>200,'duration_months'=>12,'color'=>'gold','celebrity_name'=>'MORGAN WALLEN','celebrity_image'=>null,'features'=>"All Silver Benefits\n12-Month Full Access\nVIP Priority Access\nPersonal Manager\nUnlimited Renewals\nFamily Add-ons\nConcierge Service"],
            ['name'=>'Platinum','description'=>'Ultimate elite fan membership','price'=>350,'duration_months'=>12,'color'=>'platinum','celebrity_name'=>'MORGAN WALLEN','celebrity_image'=>null,'features'=>"All Gold Benefits\nLifetime Guarantee\nGlobal Access\nPrivate Events\nDedicated Hotline\nLuxury Welcome Pack"],
        ];
        foreach($plans as $p){ Plan::firstOrCreate(['name'=>$p['name']],$p); }

        $this->command->info('✅ Database seeded!');
        $this->command->info('   Admin:  admin@demo.com / password');
        $this->command->info('   Fan:    fan@demo.com / password');
    }
}
