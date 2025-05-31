<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create admin user with specified credentials
        $adminUser = User::factory()->create([
            'name' => 'Admin WKM',
            'email' => 'admin@wkm-ind.com',
            'password' => Hash::make('qualitymgt321!'),
        ]);
        
        // Output admin credentials to console
        $this->command->info('=== ADMIN USER CREATED ===');
        $this->command->info('Email: admin@wkm-ind.com');
        $this->command->info('Password: qualitymgt321!');
        $this->command->info('========================');
        
        // HAPUS ATAU COMMENT SEEDER LAMA
        $this->call([
            EventSeeder::class,
            // ParticipantSeeder::class, // HAPUS INI
            EventRegistrationTestSeeder::class, // GUNAKAN YANG BARU
        ]);
    }
}
