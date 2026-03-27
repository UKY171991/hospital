<?php

namespace App\Filament\Resources\MedicineSales\Pages;

use App\Filament\Resources\MedicineSales\MedicineSaleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMedicineSale extends EditRecord
{
    protected static string $resource = MedicineSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
