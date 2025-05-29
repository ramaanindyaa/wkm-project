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
        Schema::create('event_team_members', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke event registration transactions
            $table->foreignId('registration_transaction_id')
                  ->constrained('event_registration_transactions')
                  ->cascadeOnDelete();
            
            // Data anggota tim
            $table->string('nama');
            $table->string('email');
            $table->string('kontak');
            $table->boolean('is_ketua')->default(false);
            
            $table->timestamps();
            
            // Indexes untuk performa
            $table->index(['registration_transaction_id']);
            $table->index(['email']);
            $table->index(['is_ketua']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_team_members');
    }
};
