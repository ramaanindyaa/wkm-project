<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'is_active' => true,
            'thumbnail' => 'events/workshop-kendali-mutu.jpg',
            'venue_thumbnail' => 'venues/hotel-grand-bintang.jpg',
            'bg_map' => 'maps/jakarta-pusat.jpg',
            'price' => 2500000,
            'is_open' => true,
            'has_started' => false,
            'time_at' => '09:00:00',
            'end_date' => '2024-08-15 17:00:00',
        ]);

        // Event 2: Seminar Teknologi Industri
        Event::create([
            'nama' => 'Seminar Teknologi Industri 4.0',
            'tanggal' => '2024-09-22',
            'lokasi' => 'Ballroom Shangri-La Hotel, Surabaya',
            'deskripsi' => 'Seminar yang membahas transformasi digital di era Industri 4.0. Topik meliputi IoT, Big Data, AI, dan otomatisasi proses industri untuk meningkatkan produktivitas dan efisiensi.',
            'is_active' => true,
            'thumbnail' => 'events/seminar-industri-4.jpg',
            'venue_thumbnail' => 'venues/shangri-la-surabaya.jpg',
            'bg_map' => 'maps/surabaya-map.jpg',
            'price' => 1500000,
            'is_open' => true,
            'has_started' => false,
            'time_at' => '08:30:00',
            'end_date' => '2024-09-22 16:30:00',
        ]);

        // Event 3: Konferensi Keselamatan Kerja (tidak aktif)
        Event::create([
            'nama' => 'Konferensi Keselamatan Kerja 2024',
            'tanggal' => '2024-11-10',
            'lokasi' => 'The Westin, Nusa Dua, Bali',
            'deskripsi' => 'Konferensi tahunan yang membahas aspek keselamatan dan kesehatan kerja di berbagai sektor industri. Acara ini menghadirkan pembicara dari regulator pemerintah dan praktisi K3.',
            'is_active' => false,
            'thumbnail' => 'events/konferensi-k3.jpg',
            'venue_thumbnail' => 'venues/westin-bali.jpg',
            'bg_map' => 'maps/nusa-dua-map.jpg',
            'price' => 3000000,
            'is_open' => false,
            'has_started' => false,
            'time_at' => '10:00:00',
            'end_date' => '2024-11-12 15:00:00',
        ]);

        // Event 4: Training ISO 9001:2015
        Event::create([
            'nama' => 'Training ISO 9001:2015 Implementation',
            'tanggal' => '2024-12-05',
            'lokasi' => 'Hotel Aston Priority, Bandung',
            'deskripsi' => 'Pelatihan intensif implementasi sistem manajemen mutu ISO 9001:2015. Cocok untuk auditor internal, quality manager, dan profesional yang terlibat dalam sistem manajemen mutu.',
            'is_active' => true,
            'thumbnail' => 'events/training-iso-9001.jpg',
            'venue_thumbnail' => 'venues/aston-bandung.jpg',
            'bg_map' => 'maps/bandung-map.jpg',
            'price' => 1800000,
            'is_open' => true,
            'has_started' => false,
            'time_at' => '09:00:00',
            'end_date' => '2024-12-07 17:00:00',
        ]);

        // Event 5: Workshop 5S Implementation
        Event::create([
            'nama' => 'Workshop 5S Implementation',
            'tanggal' => '2025-01-20',
            'lokasi' => 'Hotel Santika, Yogyakarta',
            'deskripsi' => 'Workshop praktis implementasi metodologi 5S (Sort, Set in Order, Shine, Standardize, Sustain) untuk meningkatkan efisiensi dan produktivitas di tempat kerja.',
            'is_active' => true,
            'thumbnail' => 'events/workshop-5s.jpg',
            'venue_thumbnail' => 'venues/santika-yogya.jpg',
            'bg_map' => 'maps/yogyakarta-map.jpg',
            'price' => 1200000,
            'is_open' => true,
            'has_started' => false,
            'time_at' => '08:30:00',
            'end_date' => '2025-01-20 16:00:00',
        ]);

        $this->command->info('Event seeder completed successfully!');
        $this->command->info('Created 5 events with different status and pricing.');
    }
}
