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
        Schema::table('participants', function (Blueprint $table) {
            // Tambahkan kolom untuk payment information jika belum ada
            $table->string('payment_proof')->nullable()->after('payment_status');
            $table->string('customer_bank_name')->nullable()->after('payment_proof');
            $table->string('customer_bank_account')->nullable()->after('customer_bank_name');
            $table->string('customer_bank_number')->nullable()->after('customer_bank_account');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn([
                'payment_proof',
                'customer_bank_name', 
                'customer_bank_account',
                'customer_bank_number'
            ]);
        });
    }
};
