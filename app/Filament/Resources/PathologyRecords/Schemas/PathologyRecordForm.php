<?php

namespace App\Filament\Resources\PathologyRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PathologyRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('patient_id')
                    ->required()
                    ->numeric(),
                TextInput::make('pathology_test_id')
                    ->required()
                    ->numeric(),
                TextInput::make('doctor_id')
                    ->numeric(),
                DatePicker::make('test_date')
                    ->required(),
                Textarea::make('result')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
            ]);
    }
}
