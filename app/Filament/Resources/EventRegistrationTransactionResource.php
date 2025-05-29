<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventRegistrationTransactionResource\Pages;
use App\Filament\Resources\EventRegistrationTransactionResource\RelationManagers;
use App\Models\EventRegistrationTransaction;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Model;

class EventRegistrationTransactionResource extends Resource
{
    protected static ?string $model = EventRegistrationTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationLabel = 'Event Registrations';

    protected static ?string $modelLabel = 'Event Registration';

    protected static ?string $pluralModelLabel = 'Event Registrations';

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Registration Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('registration_trx_id')
                                    ->label('Transaction ID')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder('Auto-generated'),
                                
                                Forms\Components\Select::make('event_id')
                                    ->label('Event')
                                    ->relationship('event', 'nama')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
                    ]),

                Forms\Components\Section::make('Participant Information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                                
                                Forms\Components\TextInput::make('company')
                                    ->label('Company')
                                    ->maxLength(255),
                            ]),
                    ]),

                Forms\Components\Section::make('Registration Details')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('kategori_pendaftaran')
                                    ->label('Registration Category')
                                    ->options([
                                        'observer' => 'Observer',
                                        'kompetisi' => 'Competition',
                                        'undangan' => 'Invitation',
                                    ])
                                    ->required()
                                    ->native(false),
                                
                                Forms\Components\Select::make('jenis_pendaftaran')
                                    ->label('Registration Type')
                                    ->options([
                                        'individu' => 'Individual',
                                        'tim' => 'Team',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->live(),
                                
                                Forms\Components\Select::make('payment_status')
                                    ->label('Payment Status')
                                    ->options([
                                        'pending' => 'Pending Verification',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->live(),
                            ]),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('total_amount')
                                    ->label('Total Amount')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required(),
                                
                                Forms\Components\Toggle::make('is_paid')
                                    ->label('Payment Confirmed')
                                    ->default(false),
                            ]),
                    ]),

                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('customer_bank_name')
                                    ->label('Bank Name')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('customer_bank_account')
                                    ->label('Account Holder')
                                    ->maxLength(255),
                                
                                Forms\Components\TextInput::make('customer_bank_number')
                                    ->label('Account Number')
                                    ->maxLength(255),
                            ]),
                        
                        Forms\Components\FileUpload::make('payment_proof')
                            ->label('Payment Proof')
                            ->image()
                            ->disk('public')
                            ->directory('event-payments')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ]),
                    ]),

                Forms\Components\Section::make('Competition Documents')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('google_drive_makalah')
                                    ->label('Paper Google Drive Link')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://drive.google.com/...'),
                                
                                Forms\Components\TextInput::make('google_drive_lampiran')
                                    ->label('Attachment Google Drive Link')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://drive.google.com/...'),
                                
                                Forms\Components\TextInput::make('google_drive_video_sebelum')
                                    ->label('Before Video Google Drive Link')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://drive.google.com/...'),
                                
                                Forms\Components\TextInput::make('google_drive_video_sesudah')
                                    ->label('After Video Google Drive Link')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://drive.google.com/...'),
                            ]),
                    ])
                    ->visible(fn (Forms\Get $get): bool => $get('kategori_pendaftaran') === 'kompetisi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('registration_trx_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Transaction ID copied!')
                    ->weight(FontWeight::Bold)
                    ->color('primary'),

                Tables\Columns\TextColumn::make('event.nama')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Participant')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('kategori_pendaftaran')
                    ->label('Category')
                    ->colors([
                        'secondary' => 'observer',
                        'warning' => 'kompetisi',
                        'success' => 'undangan',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'observer' => 'Observer',
                        'kompetisi' => 'Competition',
                        'undangan' => 'Invitation',
                        default => $state,
                    }),

                Tables\Columns\BadgeColumn::make('jenis_pendaftaran')
                    ->label('Type')
                    ->colors([
                        'info' => 'individu',
                        'primary' => 'tim',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'individu' => 'Individual',
                        'tim' => 'Team',
                        default => $state,
                    }),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable()
                    ->alignment('right')
                    ->weight(FontWeight::Bold)
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_paid')
                    ->label('Paid')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('team_size')
                    ->label('Team Size')
                    ->getStateUsing(fn (EventRegistrationTransaction $record): int => $record->team_size)
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('documents_complete')
                    ->label('Docs Complete')
                    ->boolean()
                    ->getStateUsing(fn (EventRegistrationTransaction $record): bool => $record->documents_complete)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered At')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'nama')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->native(false),

                SelectFilter::make('kategori_pendaftaran')
                    ->label('Category')
                    ->options([
                        'observer' => 'Observer',
                        'kompetisi' => 'Competition',
                        'undangan' => 'Invitation',
                    ])
                    ->native(false),

                SelectFilter::make('jenis_pendaftaran')
                    ->label('Type')
                    ->options([
                        'individu' => 'Individual',
                        'tim' => 'Team',
                    ])
                    ->native(false),

                Filter::make('documents_incomplete')
                    ->label('Documents Incomplete')
                    ->query(fn (Builder $query): Builder => $query->where('kategori_pendaftaran', 'kompetisi')
                        ->where('payment_status', 'approved')
                        ->where(function ($q) {
                            $q->whereNull('google_drive_makalah')
                                ->orWhereNull('google_drive_lampiran')
                                ->orWhereNull('google_drive_video_sebelum')
                                ->orWhereNull('google_drive_video_sesudah')
                                ->orWhere('google_drive_makalah', '')
                                ->orWhere('google_drive_lampiran', '')
                                ->orWhere('google_drive_video_sebelum', '')
                                ->orWhere('google_drive_video_sesudah', '');
                        })),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve_payment')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (EventRegistrationTransaction $record) => $record->update([
                        'payment_status' => 'approved',
                        'is_paid' => true,
                    ]))
                    ->visible(fn (EventRegistrationTransaction $record): bool => $record->payment_status === 'pending'),
                
                Tables\Actions\Action::make('reject_payment')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (EventRegistrationTransaction $record) => $record->update([
                        'payment_status' => 'rejected',
                        'is_paid' => false,
                    ]))
                    ->visible(fn (EventRegistrationTransaction $record): bool => $record->payment_status === 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (\Illuminate\Database\Eloquent\Collection $records) => 
                            $records->each(fn (EventRegistrationTransaction $record) => $record->update([
                                'payment_status' => 'approved',
                                'is_paid' => true,
                            ]))),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Transaction Information')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('registration_trx_id')
                                    ->label('Transaction ID')
                                    ->weight(FontWeight::Bold)
                                    ->color('primary')
                                    ->copyable(),
                                
                                Infolists\Components\TextEntry::make('event.nama')
                                    ->label('Event Name')
                                    ->weight(FontWeight::SemiBold),
                                
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Registration Date')
                                    ->dateTime('d F Y, H:i'),
                                
                                Infolists\Components\TextEntry::make('total_amount')
                                    ->label('Total Amount')
                                    ->money('IDR')
                                    ->weight(FontWeight::Bold)
                                    ->color('success'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Participant Information')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Full Name'),
                                
                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email Address'),
                                
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Phone Number'),
                                
                                Infolists\Components\TextEntry::make('company')
                                    ->label('Company')
                                    ->placeholder('Not specified'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Registration Details')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('kategori_pendaftaran_label')
                                    ->label('Category'),
                                
                                Infolists\Components\TextEntry::make('jenis_pendaftaran_label')
                                    ->label('Type'),
                                
                                Infolists\Components\TextEntry::make('payment_status_label')
                                    ->label('Payment Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Pending Verification' => 'warning',
                                        'Approved' => 'success',
                                        'Rejected' => 'danger',
                                        default => 'secondary',
                                    }),
                            ]),
                    ]),

                Infolists\Components\Section::make('Payment Information')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('customer_bank_name')
                                    ->label('Bank Name'),
                                
                                Infolists\Components\TextEntry::make('customer_bank_account')
                                    ->label('Account Holder'),
                                
                                Infolists\Components\TextEntry::make('customer_bank_number')
                                    ->label('Account Number'),
                                
                                Infolists\Components\ImageEntry::make('payment_proof')
                                    ->label('Payment Proof')
                                    ->disk('public'),
                            ]),
                    ])
                    ->visible(fn (EventRegistrationTransaction $record): bool => !empty($record->payment_proof)),

                Infolists\Components\Section::make('Competition Documents')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('google_drive_makalah')
                                    ->label('Paper Document')
                                    ->url(fn (?string $state): ?string => $state)
                                    ->openUrlInNewTab()
                                    ->placeholder('Not uploaded'),
                                
                                Infolists\Components\TextEntry::make('google_drive_lampiran')
                                    ->label('Attachment Document')
                                    ->url(fn (?string $state): ?string => $state)
                                    ->openUrlInNewTab()
                                    ->placeholder('Not uploaded'),
                                
                                Infolists\Components\TextEntry::make('google_drive_video_sebelum')
                                    ->label('Before Video')
                                    ->url(fn (?string $state): ?string => $state)
                                    ->openUrlInNewTab()
                                    ->placeholder('Not uploaded'),
                                
                                Infolists\Components\TextEntry::make('google_drive_video_sesudah')
                                    ->label('After Video')
                                    ->url(fn (?string $state): ?string => $state)
                                    ->openUrlInNewTab()
                                    ->placeholder('Not uploaded'),
                            ]),
                    ])
                    ->visible(fn (EventRegistrationTransaction $record): bool => $record->kategori_pendaftaran === 'kompetisi'),
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
            'index' => Pages\ListEventRegistrationTransactions::route('/'),
            'create' => Pages\CreateEventRegistrationTransaction::route('/create'),
            'view' => Pages\ViewEventRegistrationTransaction::route('/{record}'),
            'edit' => Pages\EditEventRegistrationTransaction::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('payment_status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }
}
