<?php

namespace App\Filament\Resources\MedicineManufacturers\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class MedicineManufacturerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Manufacturer Details')
                    ->icon(\Filament\Support\Icons\Heroicon::OutlinedBuildingOffice)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('e.g. Pfizer')
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedBuildingOffice),
                        TextInput::make('contact_number')
                            ->tel()
                            ->placeholder('+1...')
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedPhone),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->default('active')
                            ->required()
                            ->native(false),
                        Textarea::make('address')
                            ->columnSpanFull()
                            ->rows(3)
                            ->placeholder('Enter full address...'),
                    ])->columns(2),
            ]);
    }
}
