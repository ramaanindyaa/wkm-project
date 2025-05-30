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
use Illuminate\Contracts\View\View; // Add this import
use Illuminate\Support\Collection; // Add this import
use Filament\Notifications\Notification; // Add this import

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
                    ],),

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
                    ],),

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
                    ],),

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
                    ],),

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
            ->recordTitleAttribute('registration_trx_id')
            ->columns([
                Tables\Columns\TextColumn::make('registration_trx_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Transaction ID copied!')
                    ->copyMessageDuration(1500),

                Tables\Columns\TextColumn::make('event.nama')
                    ->label('Event')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 30) {
                            return $state;
                        }
                        return null;
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Participant Name')
                    ->searchable()
                    ->sortable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
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
                    ->label('Payment Status')
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

                // Documents Status Column - ONLY visible for Competition records
                Tables\Columns\BadgeColumn::make('documents_status')
                    ->label('Documents')
                    ->getStateUsing(function (EventRegistrationTransaction $record): string {
                        if ($record->payment_status !== 'approved') {
                            return 'payment_pending';
                        }
                        
                        if ($record->documents_complete) {
                            return 'complete';
                        }
                        
                        return 'incomplete';
                    })
                    ->colors([
                        'warning' => 'payment_pending',
                        'success' => 'complete',
                        'danger' => 'incomplete',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'payment_pending' => 'Pending Payment',
                        'complete' => 'Complete',
                        'incomplete' => 'Incomplete',
                        default => $state,
                    })
                    ->tooltip(function (EventRegistrationTransaction $record): ?string {
                        if ($record->payment_status !== 'approved') {
                            return 'Documents can be uploaded after payment approval';
                        }
                        
                        if ($record->documents_complete) {
                            return 'All competition documents uploaded';
                        }
                        
                        $missing = $record->missing_documents;
                        return 'Missing: ' . implode(', ', $missing);
                    })
                    ->toggleable()
                    ->toggledHiddenByDefault(false),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registration Date')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event_id')
                    ->relationship('event', 'nama')
                    ->label('Event')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending Verification',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->native(false),

                Tables\Filters\SelectFilter::make('kategori_pendaftaran')
                    ->label('Category')
                    ->options([
                        'observer' => 'Observer',
                        'kompetisi' => 'Competition',
                        'undangan' => 'Invitation',
                    ])
                    ->native(false),

                Tables\Filters\SelectFilter::make('jenis_pendaftaran')
                    ->label('Type')
                    ->options([
                        'individu' => 'Individual',
                        'tim' => 'Team',
                    ])
                    ->native(false),

                // Filter khusus untuk dokumen competition yang belum lengkap
                Tables\Filters\Filter::make('documents_incomplete')
                    ->label('Competition Documents Incomplete')
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
                        })
                    )
                    ->toggle()
                    ->indicator('Competition: Documents Incomplete'),

                // Filter khusus untuk dokumen competition yang sudah lengkap
                Tables\Filters\Filter::make('documents_complete')
                    ->label('Competition Documents Complete')
                    ->query(fn (Builder $query): Builder => $query->where('kategori_pendaftaran', 'kompetisi')
                        ->where('payment_status', 'approved')
                        ->whereNotNull('google_drive_makalah')
                        ->whereNotNull('google_drive_lampiran')
                        ->whereNotNull('google_drive_video_sebelum')
                        ->whereNotNull('google_drive_video_sesudah')
                        ->where('google_drive_makalah', '!=', '')
                        ->where('google_drive_lampiran', '!=', '')
                        ->where('google_drive_video_sebelum', '!=', '')
                        ->where('google_drive_video_sesudah', '!=', '')
                    )
                    ->toggle()
                    ->indicator('Competition: Documents Complete'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Registration From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Registration Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Details'),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
                
                // Payment Actions Group
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approve_payment')
                        ->label('Approve Payment')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading(fn (EventRegistrationTransaction $record): string => 
                            'Approve Payment - ' . $record->registration_trx_id
                        )
                        ->modalDescription(function (EventRegistrationTransaction $record): string {
                            if ($record->kategori_pendaftaran === 'kompetisi') {
                                return 'Are you sure you want to approve this payment? Participant will be able to upload competition documents after approval.';
                            }
                            return 'Are you sure you want to approve this payment? Participant will receive confirmation notification.';
                        })
                        ->modalSubmitActionLabel('Approve Payment')
                        ->action(function (EventRegistrationTransaction $record) {
                            $record->update([
                                'payment_status' => 'approved',
                                'is_paid' => true
                            ]);
                            
                            $message = 'Payment approved successfully for ' . $record->name;
                            if ($record->kategori_pendaftaran === 'kompetisi') {
                                $message .= '. Participant can now upload competition documents.';
                            }
                            
                            Notification::make()
                                ->title('Payment Approved')
                                ->body($message)
                                ->success()
                                ->send();
                        })
                        ->visible(fn (EventRegistrationTransaction $record): bool => 
                            $record->payment_status === 'pending'
                        ),

                    Tables\Actions\Action::make('reject_payment')
                        ->label('Reject Payment')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading(fn (EventRegistrationTransaction $record): string => 
                            'Reject Payment - ' . $record->registration_trx_id
                        )
                        ->modalDescription('Are you sure you want to reject this payment? This action can be reversed later if needed.')
                        ->modalSubmitActionLabel('Reject Payment')
                        ->form([
                            Forms\Components\Textarea::make('rejection_reason')
                                ->label('Rejection Reason (Optional)')
                                ->placeholder('Please provide a reason for rejection...')
                                ->rows(3)
                        ])
                        ->action(function (array $data, EventRegistrationTransaction $record) {
                            $record->update([
                                'payment_status' => 'rejected',
                                'is_paid' => false
                            ]);
                            
                            Notification::make()
                                ->title('Payment Rejected')
                                ->body('Payment rejected for ' . $record->name . '. Participant will be notified.')
                                ->warning()
                                ->send();
                        })
                        ->visible(fn (EventRegistrationTransaction $record): bool => 
                            $record->payment_status === 'pending'
                        ),

                    Tables\Actions\Action::make('reset_payment')
                        ->label('Reset to Pending')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading(fn (EventRegistrationTransaction $record): string => 
                            'Reset Payment Status - ' . $record->registration_trx_id
                        )
                        ->modalDescription('This will reset the payment status back to pending. Use this if you need to review the payment again.')
                        ->modalSubmitActionLabel('Reset Status')
                        ->action(function (EventRegistrationTransaction $record) {
                            $record->update([
                                'payment_status' => 'pending',
                                'is_paid' => false
                            ]);
                            
                            Notification::make()
                                ->title('Payment Status Reset')
                                ->body('Payment status reset to pending for ' . $record->name)
                                ->info()
                                ->send();
                        })
                        ->visible(fn (EventRegistrationTransaction $record): bool => 
                            in_array($record->payment_status, ['approved', 'rejected'])
                        ),
                ])
                ->label('Payment Actions')
                ->icon('heroicon-o-currency-dollar')
                ->color('primary')
                ->button()
                ->visible(fn (EventRegistrationTransaction $record): bool => 
                    // Show payment actions for pending, approved, or rejected payments
                    in_array($record->payment_status, ['pending', 'approved', 'rejected'])
                ),
                
                // Competition Documents Action
                Tables\Actions\Action::make('view_documents')
                    ->label('View Documents')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->visible(fn (EventRegistrationTransaction $record): bool => 
                        $record->kategori_pendaftaran === 'kompetisi' && 
                        $record->payment_status === 'approved'
                    )
                    ->modalHeading(fn (EventRegistrationTransaction $record): string => 
                        'Competition Documents - ' . $record->registration_trx_id
                    )
                    ->modalContent(function (EventRegistrationTransaction $record): View {
                        return view('filament.pages.competition-documents', [
                            'record' => $record
                        ]);
                    })
                    ->modalFooterActions([
                        Tables\Actions\Action::make('close')
                            ->label('Close')
                            ->color('gray')
                            ->close(),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    // Bulk action untuk approve payment competition registrations
                    Tables\Actions\BulkAction::make('approve_competition_payments')
                        ->label('Approve Competition Payments')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Approve Competition Payments')
                        ->modalDescription('Are you sure you want to approve payment for selected competition registrations? Participants will be able to upload their documents after approval.')
                        ->action(function (Collection $records) {
                            $competitionRecords = $records->filter(function ($record) {
                                return $record->kategori_pendaftaran === 'kompetisi' && 
                                       $record->payment_status === 'pending';
                            });
                            
                            $competitionRecords->each(function ($record) {
                                $record->update(['payment_status' => 'approved']);
                            });
                            
                            Notification::make()
                                ->title('Success')
                                ->body("Approved {$competitionRecords->count()} competition registrations. Participants can now upload documents.")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
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
