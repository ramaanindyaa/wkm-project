<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Resources\ParticipantResource;
use App\Models\TeamMember;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateParticipant extends CreateRecord
{
    protected static string $resource = ParticipantResource::class;
    
    // Override fungsi afterCreate untuk menangani pembuatan team members
    protected function afterCreate(): void
    {
        $participant = $this->record;
        
        // Jika jenis pendaftaran adalah tim dan ada data temporary_team_members
        if ($participant->jenis_pendaftaran === 'tim') {
            $teamMembers = $this->data['temporary_team_members'] ?? [];
            
            // Validasi minimal 1 ketua
            $hasLeader = false;
            foreach ($teamMembers as $member) {
                if (isset($member['is_ketua']) && $member['is_ketua']) {
                    $hasLeader = true;
                    break;
                }
            }
            
            if (!$hasLeader && count($teamMembers) > 0) {
                // Jika tidak ada ketua, set anggota pertama sebagai ketua
                $teamMembers[0]['is_ketua'] = true;
            }
            
            // Buat team members
            foreach ($teamMembers as $member) {
                TeamMember::create([
                    'participant_id' => $participant->id,
                    'nama' => $member['nama'],
                    'email' => $member['email'],
                    'kontak' => $member['kontak'],
                    'is_ketua' => $member['is_ketua'] ?? false,
                ]);
            }
        }
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
