<?php

namespace App\Filament\Resources\PathologyTests\Pages;

use App\Filament\Resources\PathologyTests\PathologyTestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPathologyTests extends ListRecords
{
    protected static string $resource = PathologyTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
