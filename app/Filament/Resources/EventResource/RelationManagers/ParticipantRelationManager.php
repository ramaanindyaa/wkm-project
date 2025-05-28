<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantsRelationManager extends RelationManager
{
    protected static string $relationship = 'participants';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kategori_pendaftaran')
                    ->options([
                        'observer' => 'Observer',
                        'kompetisi' => 'Kompetisi',
                        'undangan' => 'Undangan',
                    ])
                    ->required()
                    ->label('Kategori Pendaftaran'),

                Forms\Components\Select::make('jenis_pendaftaran')
                    ->options([
                        'individu' => 'Individu',
                        'tim' => 'Tim',
                    ])
                    ->required()
                    ->label('Jenis Pendaftaran'),

                Forms\Components\Select::make('payment_status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->required()
                    ->label('Status Pembayaran'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategori_pendaftaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'observer' => 'info',
                        'kompetisi' => 'success',
                        'undangan' => 'warning',
                        default => 'gray',
                    })
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('jenis_pendaftaran')
                    ->badge()
                    ->label('Jenis'),

                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->label('Status Pembayaran'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Waktu Pendaftaran'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}