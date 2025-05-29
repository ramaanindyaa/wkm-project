<?php

namespace App\Filament\Resources\EventRegistrationTransactionResource\Pages;

use App\Filament\Resources\EventRegistrationTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventRegistrationTransactions extends ListRecords
{
    protected static string $resource = EventRegistrationTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
