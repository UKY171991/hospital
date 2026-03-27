<?php

namespace App\Filament\Resources\MedicineSales\Pages;

use App\Filament\Resources\MedicineSales\MedicineSaleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMedicineSales extends ListRecords
{
    protected static string $resource = MedicineSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
