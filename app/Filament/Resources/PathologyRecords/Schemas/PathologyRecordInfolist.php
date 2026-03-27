<?php

namespace App\Filament\Resources\PathologyRecords\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PathologyRecordInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('patient_id')
                    ->numeric(),
                TextEntry::make('pathology_test_id')
                    ->numeric(),
                TextEntry::make('doctor_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('test_date')
                    ->date(),
                TextEntry::make('result')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
