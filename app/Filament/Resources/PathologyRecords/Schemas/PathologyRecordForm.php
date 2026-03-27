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
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                \Filament\Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('pathology_test_id')
                    ->label('Test Type')
                    ->relationship('pathologyTest', 'test_name')
                    ->required()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('doctor_id')
                    ->label('Referred By')
                    ->relationship('doctor', 'name')
                    ->searchable()
                    ->preload(),
                DatePicker::make('test_date')
                    ->required()
                    ->native(false),
                TextInput::make('status')
                    ->required()
                    ->default('pending')
                    ->placeholder('pending/completed/reported'),
                Textarea::make('result')
                    ->columnSpanFull()
                    ->rows(3),
            ])
            ->columns(2);
    }
}
