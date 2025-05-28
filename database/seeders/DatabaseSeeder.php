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

        // Buat user admin untuk login ke panel Filament
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        
        // Jalankan seeder untuk Event dan Participant
        $this->call([
            EventSeeder::class,
            ParticipantSeeder::class,
        ]);
    }
}
