<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'Peserta';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select dropdown untuk memilih event
                Forms\Components\Select::make('event_id')
                    ->relationship('event', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Event'),

                // Pilihan kategori pendaftaran
                Forms\Components\Select::make('kategori_pendaftaran')
                    ->options([
                        'observer' => 'Observer',
                        'kompetisi' => 'Kompetisi',
                        'undangan' => 'Undangan',
                    ])
                    ->required()
                    ->label('Kategori Pendaftaran'),

                // Pilihan jenis pendaftaran
                Forms\Components\Select::make('jenis_pendaftaran')
                    ->options([
                        'individu' => 'Individu',
                        'tim' => 'Tim',
                    ])
                    ->required()
                    ->live() // Penting: Agar form bereaksi ketika nilai berubah
                    ->label('Jenis Pendaftaran'),

                // Status pembayaran
                Forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->required()
                    ->live() // Penting: Agar form bereaksi ketika nilai berubah
                    ->label('Status Pembayaran'),

                // Repeater untuk anggota tim - hanya muncul jika jenis_pendaftaran = 'tim'
                Forms\Components\Section::make('Anggota Tim')
                    ->schema([
                        Forms\Components\Repeater::make('temporary_team_members')
                            ->schema([
                                Forms\Components\TextInput::make('nama')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nama Anggota'),

                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->maxLength(255)
                                    ->label('Email'),

                                Forms\Components\TextInput::make('kontak')
                                    ->required()
                                    ->maxLength(100)
                                    ->label('Nomor Kontak'),

                                Forms\Components\Checkbox::make('is_ketua')
                                    ->label('Ketua Tim?'),
                            ])
                            ->columns(2)
                            ->minItems(3) // Minimal 3 anggota
                            ->defaultItems(3)
                            ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                            ->live()
                            // Validasi bahwa minimal 1 anggota harus menjadi ketua
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $hasLeader = false;
                                foreach ($state as $member) {
                                    if (isset($member['is_ketua']) && $member['is_ketua']) {
                                        $hasLeader = true;
                                        break;
                                    }
                                }
                                
                                if (!$hasLeader) {
                                    $set('team_validation_error', 'Tim harus memiliki minimal 1 ketua');
                                } else {
                                    $set('team_validation_error', null);
                                }
                            }),
                            
                        // Field untuk menampilkan pesan error validasi tim
                        Forms\Components\TextInput::make('team_validation_error')
                            ->hidden()
                            ->dehydrated(false)
                            ->reactive()
                            ->disabled(),
                    ])
                    // Hanya tampilkan section ini jika jenis pendaftaran = tim
                    ->visible(fn (Get $get): bool => $get('jenis_pendaftaran') === 'tim'),

                // Section untuk Google Drive Links - muncul hanya jika kategori = kompetisi dan status = approved
                Forms\Components\Section::make('Dokumen Kompetisi')
                    ->schema([
                        Forms\Components\TextInput::make('google_drive_makalah')
                            ->label('Link Google Drive Makalah')
                            ->url()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('google_drive_lampiran')
                            ->label('Link Google Drive Lampiran')
                            ->url()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('google_drive_video_sebelum')
                            ->label('Link Google Drive Video Sebelum')
                            ->url()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('google_drive_video_sesudah')
                            ->label('Link Google Drive Video Sesudah')
                            ->url()
                            ->required()
                            ->maxLength(255),
                    ])
                    // Hanya tampilkan section ini jika kategori = kompetisi dan status = approved
                    ->visible(fn (Get $get): bool => 
                        $get('kategori_pendaftaran') === 'kompetisi' && 
                        $get('payment_status') === 'approved'
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Relasi ke nama event
                Tables\Columns\TextColumn::make('event.nama')
                    ->sortable()
                    ->searchable()
                    ->label('Event'),

                // Kategori pendaftaran
                Tables\Columns\TextColumn::make('kategori_pendaftaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'observer' => 'info',
                        'kompetisi' => 'success',
                        'undangan' => 'warning',
                        default => 'gray',
                    })
                    ->label('Kategori'),

                // Jenis pendaftaran
                Tables\Columns\TextColumn::make('jenis_pendaftaran')
                    ->badge()
                    ->label('Jenis'),

                // Status pembayaran
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->label('Status Pembayaran'),

                // Badge khusus untuk kompetisi yang belum upload dokumen
                Tables\Columns\IconColumn::make('documents_completed')
                    ->label('Dokumen Lengkap')
                    ->boolean()
                    ->getStateUsing(function (Participant $record): bool {
                        if ($record->kategori_pendaftaran === 'kompetisi' && $record->payment_status === 'approved') {
                            return !empty($record->google_drive_makalah) && 
                                !empty($record->google_drive_lampiran) && 
                                !empty($record->google_drive_video_sebelum) && 
                                !empty($record->google_drive_video_sesudah);
                        }
                        
                        return true; // Tidak relevan untuk kategori lain
                    })
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-exclamation-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event_id')
                    ->relationship('event', 'nama')
                    ->label('Filter berdasarkan Event'),
                    
                Tables\Filters\SelectFilter::make('kategori_pendaftaran')
                    ->options([
                        'observer' => 'Observer',
                        'kompetisi' => 'Kompetisi',
                        'undangan' => 'Undangan',
                    ])
                    ->label('Filter berdasarkan Kategori'),
                    
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->label('Filter berdasarkan Status Pembayaran'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TeamMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'edit' => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }
}
