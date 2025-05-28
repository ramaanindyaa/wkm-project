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
        Schema::create('team_members', function (Blueprint $table) {
            // Kolom utama dengan auto-increment
            $table->id();
            
            // Foreign key ke tabel participants dengan cascade on delete
            // Artinya: jika participant terkait dihapus, semua anggota tim juga akan dihapus
            $table->foreignId('participant_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Informasi anggota tim
            $table->string('nama', 255);
            $table->string('email', 255);
            $table->string('kontak', 100);
            
            // Flag untuk menandai ketua tim
            $table->boolean('is_ketua')->default(false);
            
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
        Schema::dropIfExists('team_members');
    }
};
