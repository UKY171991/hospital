<?php

namespace App\Filament\Resources\PathologyTests\Pages;

use App\Filament\Resources\PathologyTests\PathologyTestResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPathologyTest extends EditRecord
{
    protected static string $resource = PathologyTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
