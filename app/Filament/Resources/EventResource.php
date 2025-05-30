<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventResource extends Resource
{
    /**
     * Model yang digunakan oleh resource ini
     */
    protected static ?string $model = Event::class;

    /**
     * Icon navigasi untuk resource ini
     */
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    /**
     * Label navigasi untuk resource ini
     */
    protected static ?string $navigationLabel = 'Events';

    /**
     * Mendefinisikan struktur form untuk pembuatan dan pengeditan event
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informasi Utama')
                    ->schema([
                        // Nama event (wajib diisi, maksimal 255 karakter)
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Event'),

                        // Lokasi event (wajib diisi, maksimal 255 karakter)
                        Forms\Components\TextInput::make('lokasi')
                            ->required()
                            ->maxLength(255)
                            ->label('Lokasi'),

                        // Upload gambar thumbnail event
                        Forms\Components\FileUpload::make('thumbnail')
                            ->image()
                            ->directory('events/thumbnails')
                            ->label('Thumbnail Event'),

                        // Upload gambar venue thumbnail
                        Forms\Components\FileUpload::make('venue_thumbnail')
                            ->image()
                            ->directory('events/venue')
                            ->label('Thumbnail Lokasi'),

                        // Upload gambar background map
                        Forms\Components\FileUpload::make('bg_map')
                            ->image()
                            ->directory('events/maps')
                            ->label('Background Map'),

                        // Repeater untuk benefits event
                        Forms\Components\Repeater::make('benefits')
                            ->relationship('benefits')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Benefit'),
                            ])
                            ->label('Benefits Event'),
                    ],),

                Fieldset::make('Detail Tambahan')
                    ->schema([
                        // Deskripsi event (opsional)
                        Forms\Components\Textarea::make('deskripsi')
                            ->nullable()
                            ->label('Deskripsi')
                            ->rows(4),

                        // Harga event
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR')
                            ->label('Harga'),

                        // Status ketersediaan event
                        Forms\Components\Select::make('is_open')
                            ->options([
                                true => 'Tersedia',
                                false => 'Tidak Tersedia',
                            ])
                            ->default(true)
                            ->label('Status Ketersediaan'),

                        // Status event sudah dimulai
                        Forms\Components\Select::make('has_started')
                            ->options([
                                true => 'Sudah Dimulai',
                                false => 'Belum Dimulai',
                            ])
                            ->default(false)
                            ->label('Status Mulai'),

                        // Status aktif event (default: aktif/true)
                        Forms\Components\Toggle::make('is_active') // Ganti status_aktif menjadi is_active
                            ->default(true)
                            ->label('Status Aktif'),
                    ]),

                Fieldset::make('Waktu Pelaksanaan')
                    ->schema([
                        // Tanggal pelaksanaan event (wajib diisi)
                        Forms\Components\DatePicker::make('tanggal')
                            ->required()
                            ->label('Tanggal Mulai'),

                        // Tanggal berakhir event
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Tanggal Berakhir'),

                        // Waktu pelaksanaan event
                        Forms\Components\TimePicker::make('time_at')
                            ->required()
                            ->label('Waktu Pelaksanaan'),
                    ]),
            ]);
    }

    /**
     * Mendefinisikan struktur tabel untuk menampilkan daftar event
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Thumbnail event
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular()
                    ->size(50),

                // Kolom nama event
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Event')
                    ->searchable()
                    ->sortable(),

                // Kolom tanggal dengan format yang lebih mudah dibaca
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal Pelaksanaan')
                    ->date('d F Y') // Format: 25 Desember 2024
                    ->sortable(),

                // Kolom lokasi event
                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable(),

                // Kolom harga event
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->label('Harga'),

                // Status event sudah dimulai atau belum
                Tables\Columns\IconColumn::make('has_started')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->label('Dimulai'),

                // Kolom status aktif dengan indikator badge
                Tables\Columns\IconColumn::make('is_active') // Ganti status_aktif menjadi is_active
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                // Jumlah peserta event - FIX THIS LINE
                Tables\Columns\TextColumn::make('eventRegistrationTransactions_count')
                    ->counts('eventRegistrationTransactions')
                    ->label('Peserta'),
            ])
            ->filters([
                // Filter berdasarkan status aktif
                Tables\Filters\SelectFilter::make('is_active') // Ganti status_aktif menjadi is_active
                    ->options([
                        true => 'Aktif',
                        false => 'Tidak Aktif',
                    ])
                    ->label('Filter Status'),

                // Filter berdasarkan tanggal
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_dari')
                            ->label('Tanggal Dari'),
                        Forms\Components\DatePicker::make('tanggal_sampai')
                            ->label('Tanggal Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_dari'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_sampai'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                // Tombol aksi untuk mengedit event
                Tables\Actions\EditAction::make(),

                // Tombol aksi untuk melihat detail event
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // Aksi bulk untuk menghapus beberapa event sekaligus
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Mendefinisikan relation managers yang digunakan resource ini
     */
    public static function getRelations(): array
    {
        return [
            // Remove or comment out the non-existent relation manager
            // RelationManagers\EventRegistrationTransactionsRelationManager::class,
        ];
    }

    /**
     * Mendefinisikan halaman-halaman yang tersedia untuk resource ini
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}