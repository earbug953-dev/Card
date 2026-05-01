<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('membership_cards', function (Blueprint $table) {
            $table->foreignId('purchase_transaction_id')->nullable()->after('plan_id')->constrained('purchase_transactions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_cards', function (Blueprint $table) {
            $table->dropForeignKeyIfExists('membership_cards_purchase_transaction_id_foreign');
            $table->dropColumn('purchase_transaction_id');
        });
    }
};
