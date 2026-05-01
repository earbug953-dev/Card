<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Celebrity fields on plans
        if (!Schema::hasColumn('plans', 'celebrity_name')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->string('celebrity_name')->nullable()->after('features');
                $table->string('celebrity_image')->nullable()->after('celebrity_name');
            });
        }

        // Extra user fields (is_admin already added by earlier migration)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'user_photo'))
                $table->string('user_photo')->nullable()->after('email');
            if (!Schema::hasColumn('users', 'phone'))
                $table->string('phone')->nullable();
            if (!Schema::hasColumn('users', 'address'))
                $table->string('address')->nullable();
        });

        // Extra fields on purchase_transactions
        Schema::table('purchase_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_transactions', 'user_photo_path'))
                $table->string('user_photo_path')->nullable()->after('payment_notes');
            if (!Schema::hasColumn('purchase_transactions', 'user_address'))
                $table->string('user_address')->nullable();
            if (!Schema::hasColumn('purchase_transactions', 'user_phone'))
                $table->string('user_phone')->nullable();
        });
    }

    public function down(): void {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['celebrity_name', 'celebrity_image']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_photo', 'phone', 'address']);
        });
        Schema::table('purchase_transactions', function (Blueprint $table) {
            $table->dropColumn(['user_photo_path', 'user_address', 'user_phone']);
        });
    }
};
