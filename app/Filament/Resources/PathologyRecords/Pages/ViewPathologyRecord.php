<?php

namespace App\Filament\Resources\PathologyRecords\Pages;

use App\Filament\Resources\PathologyRecords\PathologyRecordResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPathologyRecord extends ViewRecord
{
    protected static string $resource = PathologyRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
