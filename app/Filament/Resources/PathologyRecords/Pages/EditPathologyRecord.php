<?php

namespace App\Filament\Resources\PathologyRecords\Pages;

use App\Filament\Resources\PathologyRecords\PathologyRecordResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPathologyRecord extends EditRecord
{
    protected static string $resource = PathologyRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
