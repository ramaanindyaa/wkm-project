<?php

namespace App\Filament\Resources\EventRegistrationTransactionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'teamMembers';

    protected static ?string $title = 'Team Members';

    protected static ?string $modelLabel = 'Team Member';

    protected static ?string $pluralModelLabel = 'Team Members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('kontak')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(100),
                        
                        Forms\Components\Toggle::make('is_ketua')
                            ->label('Team Leader')
                            ->default(false)
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, $state) {
                                // If this member is set as leader, unset others
                                if ($state) {
                                    // This will be handled by the model's setAsLeader method
                                }
                            }),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('kontak')
                    ->label('Phone')
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_ketua')
                    ->label('Leader')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Team Leader' => 'success',
                        'Team Member' => 'primary',
                        default => 'secondary',
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('leaders_only')
                    ->label('Leaders Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_ketua', true)),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Ensure only one leader per team
                        if ($data['is_ketua'] ?? false) {
                            $this->getOwnerRecord()->teamMembers()
                                ->where('id', '!=', $data['id'] ?? null)
                                ->update(['is_ketua' => false]);
                        }
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, $record): array {
                        // Ensure only one leader per team
                        if ($data['is_ketua'] ?? false) {
                            $this->getOwnerRecord()->teamMembers()
                                ->where('id', '!=', $record->id)
                                ->update(['is_ketua' => false]);
                        }
                        return $data;
                    }),
                
                Tables\Actions\Action::make('set_as_leader')
                    ->label('Set as Leader')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->setAsLeader();
                    })
                    ->visible(fn ($record): bool => !$record->is_ketua),
                
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('is_ketua', 'desc')
            ->emptyStateHeading('No team members')
            ->emptyStateDescription('This registration doesn\'t have any team members yet.')
            ->emptyStateIcon('heroicon-o-users');
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
