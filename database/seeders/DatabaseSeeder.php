<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        
        // HAPUS ATAU COMMENT SEEDER LAMA
        $this->call([
            EventSeeder::class,
            // ParticipantSeeder::class, // HAPUS INI
            EventRegistrationTestSeeder::class, // GUNAKAN YANG BARU
        ]);
    }
}
