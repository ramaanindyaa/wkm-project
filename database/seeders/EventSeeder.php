<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Event 1: Workshop Kendali Mutu
        Event::create([
            'nama' => 'Workshop Kendali Mutu 2024',
            'tanggal' => '2024-08-15',
            'lokasi' => 'Hotel Grand Bitang, Jakarta Pusat',
            'deskripsi' => 'Workshop intensif tentang penerapan sistem kendali mutu di industri manufaktur. Acara ini akan membahas standar ISO 9001:2015 dan praktik terbaik dalam implementasi quality control.',
            'is_active' => true, // Ganti status_aktif menjadi is_active
        ]);

        // Event 2: Seminar Teknologi Industri
        Event::create([
            'nama' => 'Seminar Teknologi Industri 4.0',
            'tanggal' => '2024-09-22',
            'lokasi' => 'Ballroom Shangri-La Hotel, Surabaya',
            'deskripsi' => 'Seminar yang membahas transformasi digital di era Industri 4.0. Topik meliputi IoT, Big Data, AI, dan otomatisasi proses industri untuk meningkatkan produktivitas dan efisiensi.',
            'is_active' => true, // Ganti status_aktif menjadi is_active
        ]);

        // Event 3: Konferensi Keselamatan Kerja (tidak aktif)
        Event::create([
            'nama' => 'Konferensi Keselamatan Kerja 2024',
            'tanggal' => '2024-11-10',
            'lokasi' => 'The Westin, Nusa Dua, Bali',
            'deskripsi' => 'Konferensi tahunan yang membahas aspek keselamatan dan kesehatan kerja di berbagai sektor industri. Acara ini menghadirkan pembicara dari regulator pemerintah dan praktisi K3.',
            'is_active' => false, // Ganti status_aktif menjadi is_active
        ]);
    }
}
