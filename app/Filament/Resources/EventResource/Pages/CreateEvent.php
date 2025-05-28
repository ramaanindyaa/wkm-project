<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    /**
     * Resource yang terkait dengan halaman ini
     */
    protected static string $resource = EventResource::class;

    /**
     * Redirect ke halaman daftar event setelah berhasil membuat event
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}