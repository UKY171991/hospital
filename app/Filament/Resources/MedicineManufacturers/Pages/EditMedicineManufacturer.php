<?php

namespace App\Filament\Resources\MedicineManufacturers\Pages;

use App\Filament\Resources\MedicineManufacturers\MedicineManufacturerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMedicineManufacturer extends EditRecord
{
    protected static string $resource = MedicineManufacturerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
