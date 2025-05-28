<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    /**
     * Resource yang terkait dengan halaman ini
     */
    protected static string $resource = EventResource::class;

    /**
     * Mendefinisikan aksi-aksi yang tersedia di header halaman
     */
    protected function getHeaderActions(): array
    {
        return [
            // Tombol untuk menghapus event
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Redirect ke halaman daftar event setelah berhasil mengedit event
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}