<?php

namespace App\Filament\Resources\PathologyRecords\Pages;

use App\Filament\Resources\PathologyRecords\PathologyRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPathologyRecords extends ListRecords
{
    protected static string $resource = PathologyRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
