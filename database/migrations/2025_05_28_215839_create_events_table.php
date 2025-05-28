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
        Schema::create('events', function (Blueprint $table) {
            // Kolom utama dengan auto-increment
            $table->id();
            
            // Informasi dasar event
            $table->string('nama', 255);
            $table->date('tanggal');
            $table->string('lokasi', 255);
            $table->text('deskripsi')->nullable();
            
            // Status event (aktif/tidak aktif)
            $table->boolean('status_aktif')->default(true);
            
            // Created_at dan updated_at timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel jika migration di-rollback
        Schema::dropIfExists('events');
    }
};
