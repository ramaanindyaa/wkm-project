<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventRegistrationTransaction;
use App\Models\EventTeamMember;
use Illuminate\Database\Seeder;

class EventRegistrationTestSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::where('is_active', true)->get();
        
        if ($events->isEmpty()) {
            $this->command->error('No active events found. Run EventSeeder first.');
            return;
        }

        // Test Transaction 1: Individual Observer (Pending)
        $transaction1 = EventRegistrationTransaction::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+62812345678901',
            'company' => 'PT Example Corp',
            'event_id' => $events->first()->id,
            'kategori_pendaftaran' => 'observer',
            'jenis_pendaftaran' => 'individu',
            'payment_status' => 'pending',
            'total_amount' => $events->first()->price * 1.11,
            'customer_bank_name' => 'BCA',
            'customer_bank_account' => 'John Doe',
            'customer_bank_number' => '1234567890',
            'payment_proof' => 'event-payments/sample-proof-1.jpg',
            'is_paid' => false,
        ]);

        // Test Transaction 2: Team Competition (Approved with documents)
        $transaction2 = EventRegistrationTransaction::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'phone' => '+62812345678902',
            'company' => 'PT Innovation Labs',
            'event_id' => $events->first()->id,
            'kategori_pendaftaran' => 'kompetisi',
            'jenis_pendaftaran' => 'tim',
            'payment_status' => 'approved',
            'total_amount' => $events->first()->price * 3 * 1.11,
            'customer_bank_name' => 'Mandiri',
            'customer_bank_account' => 'Jane Smith',
            'customer_bank_number' => '0987654321',
            'payment_proof' => 'event-payments/sample-proof-2.jpg',
            'is_paid' => true,
            'google_drive_makalah' => 'https://drive.google.com/file/d/sample-paper',
            'google_drive_lampiran' => 'https://drive.google.com/file/d/sample-attachment',
            'google_drive_video_sebelum' => 'https://drive.google.com/file/d/sample-before-video',
            'google_drive_video_sesudah' => 'https://drive.google.com/file/d/sample-after-video',
        ]);

        // Add team members for transaction 2
        EventTeamMember::create([
            'registration_transaction_id' => $transaction2->id,
            'nama' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'kontak' => '+62812345678902',
            'is_ketua' => true,
        ]);

        EventTeamMember::create([
            'registration_transaction_id' => $transaction2->id,
            'nama' => 'Bob Johnson',
            'email' => 'bob.johnson@example.com',
            'kontak' => '+62812345678903',
            'is_ketua' => false,
        ]);

        EventTeamMember::create([
            'registration_transaction_id' => $transaction2->id,
            'nama' => 'Alice Brown',
            'email' => 'alice.brown@example.com',
            'kontak' => '+62812345678904',
            'is_ketua' => false,
        ]);

        // Test Transaction 3: Team Competition (Approved without documents)
        $transaction3 = EventRegistrationTransaction::create([
            'name' => 'Michael Wilson',
            'email' => 'michael.wilson@example.com',
            'phone' => '+62812345678905',
            'company' => 'PT Tech Solutions',
            'event_id' => $events->count() > 1 ? $events[1]->id : $events->first()->id,
            'kategori_pendaftaran' => 'kompetisi',
            'jenis_pendaftaran' => 'tim',
            'payment_status' => 'approved',
            'total_amount' => $events->first()->price * 4 * 1.11,
            'customer_bank_name' => 'BNI',
            'customer_bank_account' => 'Michael Wilson',
            'customer_bank_number' => '5555666677',
            'payment_proof' => 'event-payments/sample-proof-3.jpg',
            'is_paid' => true,
            // No documents uploaded yet
        ]);

        // Add team members for transaction 3
        EventTeamMember::create([
            'registration_transaction_id' => $transaction3->id,
            'nama' => 'Michael Wilson',
            'email' => 'michael.wilson@example.com',
            'kontak' => '+62812345678905',
            'is_ketua' => true,
        ]);

        EventTeamMember::create([
            'registration_transaction_id' => $transaction3->id,
            'nama' => 'Sarah Davis',
            'email' => 'sarah.davis@example.com',
            'kontak' => '+62812345678906',
            'is_ketua' => false,
        ]);

        EventTeamMember::create([
            'registration_transaction_id' => $transaction3->id,
            'nama' => 'Tom Anderson',
            'email' => 'tom.anderson@example.com',
            'kontak' => '+62812345678907',
            'is_ketua' => false,
        ]);

        EventTeamMember::create([
            'registration_transaction_id' => $transaction3->id,
            'nama' => 'Lisa Garcia',
            'email' => 'lisa.garcia@example.com',
            'kontak' => '+62812345678908',
            'is_ketua' => false,
        ]);

        // Test Transaction 4: Individual Invitation (Rejected)
        $transaction4 = EventRegistrationTransaction::create([
            'name' => 'David Lee',
            'email' => 'david.lee@example.com',
            'phone' => '+62812345678909',
            'company' => null,
            'event_id' => $events->first()->id,
            'kategori_pendaftaran' => 'undangan',
            'jenis_pendaftaran' => 'individu',
            'payment_status' => 'rejected',
            'total_amount' => $events->first()->price * 1.11,
            'customer_bank_name' => 'BRI',
            'customer_bank_account' => 'David Lee',
            'customer_bank_number' => '9999888877',
            'payment_proof' => 'event-payments/sample-proof-4.jpg',
            'is_paid' => false,
        ]);

        $this->command->info('Test event registration data created successfully!');
        $this->command->info('Transaction IDs for testing:');
        $this->command->info('1. Individual Observer (Pending): ' . $transaction1->registration_trx_id);
        $this->command->info('2. Team Competition (Approved with docs): ' . $transaction2->registration_trx_id);
        $this->command->info('3. Team Competition (Approved no docs): ' . $transaction3->registration_trx_id);
        $this->command->info('4. Individual Invitation (Rejected): ' . $transaction4->registration_trx_id);
    }
}