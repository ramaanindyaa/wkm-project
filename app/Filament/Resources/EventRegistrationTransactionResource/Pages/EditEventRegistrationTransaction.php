<?php

namespace App\Filament\Resources\EventRegistrationTransactionResource\Pages;

use App\Filament\Resources\EventRegistrationTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventRegistrationTransaction extends EditRecord
{
    protected static string $resource = EventRegistrationTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
