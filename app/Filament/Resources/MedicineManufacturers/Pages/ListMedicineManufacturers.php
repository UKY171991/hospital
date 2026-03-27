<?php

namespace App\Filament\Resources\MedicineManufacturers\Pages;

use App\Filament\Resources\MedicineManufacturers\MedicineManufacturerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMedicineManufacturers extends ListRecords
{
    protected static string $resource = MedicineManufacturerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
