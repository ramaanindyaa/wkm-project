<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkshopParticipantResource\Pages;
use App\Filament\Resources\WorkshopParticipantResource\RelationManagers;
use App\Models\WorkshopParticipant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorkshopParticipantResource extends Resource
{
    protected static ?string $model = WorkshopParticipant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('occupation')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('company')
                    ->maxLength(255)
                    ->placeholder('Company name'),

                Forms\Components\Select::make('workshop_id')
                    ->relationship('workshop', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('booking_transaction_id')
                    ->relationship('bookingTransaction', 'booking_trx_id')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

                Tables\Columns\ImageColumn::make('workshop.thumbnail'),

                Tables\Columns\TextColumn::make('bookingTransaction.booking_trx_id')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('company')
                    ->searchable()
                    ->toggleable(), // Makes it optional to display
            ])
            ->filters([
                //
                SelectFilter::make('workshop_id')
                    ->label('workshop')
                    ->relationship('workshop', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkshopParticipants::route('/'),
            'create' => Pages\CreateWorkshopParticipant::route('/create'),
            'edit' => Pages\EditWorkshopParticipant::route('/{record}/edit'),
        ];
    }
}
