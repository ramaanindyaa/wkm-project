<?php

namespace App\Filament\Resources\EventRegistrationTransactionResource\Pages;

use App\Filament\Resources\EventRegistrationTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEventRegistrationTransaction extends ViewRecord
{
    protected static string $resource = EventRegistrationTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
