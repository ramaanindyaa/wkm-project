<?php

namespace App\Filament\Resources\ParticipantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class TeamMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'teamMembers';

    // Hanya tampilkan relation manager ini jika participant memiliki jenis_pendaftaran = tim
    public function canView(Model $record): bool
    {
        return $this->ownerRecord->jenis_pendaftaran === 'tim';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Anggota'),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->maxLength(100)
                    ->tel(),

                Forms\Components\Checkbox::make('is_ketua')
                    ->label('Ketua Tim?'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                    
                Tables\Columns\IconColumn::make('is_ketua')
                    ->boolean()
                    ->label('Ketua'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    // Validasi minimal 1 ketua
                    ->before(function (RelationManager $livewire) {
                        // Hitung jumlah anggota tim
                        $teamMemberCount = $livewire->ownerRecord->teamMembers()->count();
                        
                        // Jika belum ada anggota, biarkan walaupun belum ada ketua
                        if ($teamMemberCount == 0) {
                            return;
                        }
                        
                        // Hitung berapa ketua yang sudah ada
                        $leaderCount = $livewire->ownerRecord->teamMembers()->where('is_ketua', true)->count();
                        
                        // Jika tidak ada ketua dan yang baru dibuat bukan ketua, throw error
                        if ($leaderCount == 0 && !request()->boolean('data.is_ketua')) {
                            throw new \Exception('Tim harus memiliki minimal 1 ketua.');
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    // Validasi jangan hapus ketua jika hanya ada 1
                    ->before(function (Tables\Actions\DeleteAction $action, Model $record) {
                        if ($record->is_ketua) {
                            $leaderCount = $record->participant->teamMembers()->where('is_ketua', true)->count();
                            if ($leaderCount <= 1) {
                                $action->cancel();
                                $action->failureNotification()?->send();
                                throw new \Exception('Tidak dapat menghapus satu-satunya ketua tim. Jadikan anggota lain sebagai ketua terlebih dahulu.');
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        // Validasi jangan sampai semua ketua terhapus
                        ->before(function (Tables\Actions\DeleteBulkAction $action, RelationManager $livewire, array $records) {
                            $allLeaderIds = $livewire->ownerRecord->teamMembers()
                                ->where('is_ketua', true)
                                ->pluck('id')
                                ->toArray();
                                
                            $selectedRecordIds = collect($records)->pluck('id')->toArray();
                            
                            $remainingLeaders = array_diff($allLeaderIds, $selectedRecordIds);
                            
                            if (empty($remainingLeaders) && !empty($allLeaderIds)) {
                                $action->cancel();
                                $action->failureNotification()?->send();
                                throw new \Exception('Tidak dapat menghapus semua ketua tim. Minimal harus ada 1 ketua.');
                            }
                        }),
                ]),
            ]);
    }
}
