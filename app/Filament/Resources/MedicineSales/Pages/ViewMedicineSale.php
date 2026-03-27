<?php

namespace App\Filament\Resources\MedicineSales\Pages;

use App\Filament\Resources\MedicineSales\MedicineSaleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMedicineSale extends ViewRecord
{
    protected static string $resource = MedicineSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
