<?php

namespace App\Filament\Resources\PathologyTests\Pages;

use App\Filament\Resources\PathologyTests\PathologyTestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPathologyTest extends ViewRecord
{
    protected static string $resource = PathologyTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
