<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Langkah 1: Tambahkan kolom baru
            $table->boolean('is_active')->default(true)->after('status_aktif');
        });

        // Langkah 2: Salin data dari kolom lama ke kolom baru
        DB::statement('UPDATE events SET is_active = status_aktif');

        Schema::table('events', function (Blueprint $table) {
            // Langkah 3: Hapus kolom lama
            $table->dropColumn('status_aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Langkah 1: Tambahkan kolom lama kembali
            $table->boolean('status_aktif')->default(true)->after('is_active');
        });

        // Langkah 2: Salin data dari kolom baru ke kolom lama
        DB::statement('UPDATE events SET status_aktif = is_active');

        Schema::table('events', function (Blueprint $table) {
            // Langkah 3: Hapus kolom baru
            $table->dropColumn('is_active');
        });
    }
};
