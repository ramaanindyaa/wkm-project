<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
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
            // Tombol untuk membuat event baru
            Actions\CreateAction::make(),
        ];
    }
}