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
        Schema::create('event_registration_transactions', function (Blueprint $table) {
            $table->id();
            
            // Basic Transaction Info
            $table->string('registration_trx_id')->unique();
            $table->boolean('is_paid')->default(false);
            
            // Personal Information
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('company')->nullable();
            
            // Event Registration Details
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->enum('kategori_pendaftaran', ['observer', 'kompetisi', 'undangan']);
            $table->enum('jenis_pendaftaran', ['individu', 'tim']);
            $table->enum('payment_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->decimal('total_amount', 15, 2);
            
            // Payment Information
            $table->string('customer_bank_name')->nullable();
            $table->string('customer_bank_account')->nullable();
            $table->string('customer_bank_number')->nullable();
            $table->string('payment_proof')->nullable();
            
            // Competition Documents (for kompetisi category)
            $table->text('google_drive_makalah')->nullable();
            $table->text('google_drive_lampiran')->nullable();
            $table->text('google_drive_video_sebelum')->nullable();
            $table->text('google_drive_video_sesudah')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['registration_trx_id']);
            $table->index(['event_id', 'payment_status']);
            $table->index(['email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registration_transactions');
    }
};
