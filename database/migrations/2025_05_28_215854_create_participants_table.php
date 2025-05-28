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
        Schema::create('participants', function (Blueprint $table) {
            // Kolom utama dengan auto-increment
            $table->id();
            
            // Foreign key ke tabel events dengan cascade on delete
            // Artinya: jika event terkait dihapus, participant juga akan dihapus
            $table->foreignId('event_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Kategori pendaftaran menggunakan tipe enum
            $table->enum('kategori_pendaftaran', ['observer', 'kompetisi', 'undangan']);
            
            // Jenis pendaftaran menggunakan tipe enum
            $table->enum('jenis_pendaftaran', ['individu', 'tim']);
            
            // Status pembayaran dengan default 'pending'
            $table->enum('payment_status', ['pending', 'approved', 'rejected'])
                  ->default('pending');
            
            // Link Google Drive untuk dokumen-dokumen (nullable berarti boleh kosong)
            $table->string('google_drive_makalah')->nullable();
            $table->string('google_drive_lampiran')->nullable();
            $table->string('google_drive_video_sebelum')->nullable();
            $table->string('google_drive_video_sesudah')->nullable();
            
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
        Schema::dropIfExists('participants');
    }
};
