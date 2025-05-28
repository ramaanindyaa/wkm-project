<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Participant;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dapatkan semua event yang telah dibuat
        $events = Event::all();
        
        if ($events->isEmpty()) {
            $this->command->error('Tidak ada event yang ditemukan. Jalankan EventSeeder terlebih dahulu.');
            return;
        }

        // 1. Buat peserta individu kategori observer dengan status pending
        $this->createIndividualParticipant(
            $events[0]->id, 
            'observer', 
            'pending'
        );
        
        // 2. Buat peserta individu kategori undangan dengan status approved
        $this->createIndividualParticipant(
            $events[0]->id, 
            'undangan', 
            'approved'
        );
        
        // 3. Buat peserta individu kategori kompetisi dengan status rejected
        $this->createIndividualParticipant(
            $events[1]->id, 
            'kompetisi', 
            'rejected'
        );
        
        // 4. Buat peserta tim kategori kompetisi dengan status approved (lengkap dengan links)
        $this->createTeamParticipant(
            $events[1]->id, 
            'kompetisi', 
            'approved', 
            true
        );
        
        // 5. Buat peserta tim kategori kompetisi dengan status approved (belum upload links)
        $this->createTeamParticipant(
            $events[0]->id, 
            'kompetisi', 
            'approved', 
            false
        );
        
        // 6. Buat peserta tim kategori observer dengan status pending
        $this->createTeamParticipant(
            $events[1]->id, 
            'observer', 
            'pending', 
            false
        );
        
        // 7. Buat peserta tim kategori undangan dengan status approved
        $this->createTeamParticipant(
            $events[0]->id, 
            'undangan', 
            'approved', 
            false
        );
    }
    
    /**
     * Buat peserta individu
     * 
     * @param int $eventId
     * @param string $kategori
     * @param string $status
     * @return void
     */
    private function createIndividualParticipant($eventId, $kategori, $status): void
    {
        $participant = Participant::create([
            'event_id' => $eventId,
            'kategori_pendaftaran' => $kategori,
            'jenis_pendaftaran' => 'individu',
            'payment_status' => $status,
        ]);
        
        // Jika kompetisi dan approved, tambahkan links Google Drive
        if ($kategori === 'kompetisi' && $status === 'approved') {
            $participant->update([
                'google_drive_makalah' => 'https://drive.google.com/file/d/sample-makalah',
                'google_drive_lampiran' => 'https://drive.google.com/file/d/sample-lampiran',
                'google_drive_video_sebelum' => 'https://drive.google.com/file/d/sample-video-sebelum',
                'google_drive_video_sesudah' => 'https://drive.google.com/file/d/sample-video-sesudah',
            ]);
        }
    }
    
    /**
     * Buat peserta tim dengan anggota
     * 
     * @param int $eventId
     * @param string $kategori
     * @param string $status
     * @param bool $withLinks
     * @return void
     */
    private function createTeamParticipant($eventId, $kategori, $status, $withLinks): void
    {
        $participant = Participant::create([
            'event_id' => $eventId,
            'kategori_pendaftaran' => $kategori,
            'jenis_pendaftaran' => 'tim',
            'payment_status' => $status,
        ]);
        
        // Jika kategori kompetisi, status approved, dan perlu links
        if ($kategori === 'kompetisi' && $status === 'approved' && $withLinks) {
            $participant->update([
                'google_drive_makalah' => 'https://drive.google.com/file/d/complete-makalah',
                'google_drive_lampiran' => 'https://drive.google.com/file/d/complete-lampiran',
                'google_drive_video_sebelum' => 'https://drive.google.com/file/d/complete-video-sebelum',
                'google_drive_video_sesudah' => 'https://drive.google.com/file/d/complete-video-sesudah',
            ]);
        } else if ($kategori === 'kompetisi' && $status === 'approved' && !$withLinks) {
            // Biarkan links kosong untuk menguji fitur "belum upload dokumen"
        }
        
        // Buat anggota tim (minimal 3)
        
        // Anggota 1 (Ketua)
        TeamMember::create([
            'participant_id' => $participant->id,
            'nama' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'kontak' => '081234567890',
            'is_ketua' => true,
        ]);
        
        // Anggota 2
        TeamMember::create([
            'participant_id' => $participant->id,
            'nama' => 'Dewi Lestari',
            'email' => 'dewi.lestari@example.com',
            'kontak' => '085678901234',
            'is_ketua' => false,
        ]);
        
        // Anggota 3
        TeamMember::create([
            'participant_id' => $participant->id,
            'nama' => 'Agus Priyanto',
            'email' => 'agus.priyanto@example.com',
            'kontak' => '087890123456',
            'is_ketua' => false,
        ]);
        
        // Anggota 4 (tambahan)
        TeamMember::create([
            'participant_id' => $participant->id,
            'nama' => 'Rani Wijaya',
            'email' => 'rani.wijaya@example.com',
            'kontak' => '089012345678',
            'is_ketua' => false,
        ]);
    }
}
