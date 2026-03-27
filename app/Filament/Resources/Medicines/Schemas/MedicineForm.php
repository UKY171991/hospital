<?php

namespace App\Filament\Resources\Medicines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MedicineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Paracetamol 500mg'),
                \Filament\Forms\Components\Select::make('medicine_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')->required()->unique('medicine_categories', 'name'),
                    ]),
                \Filament\Forms\Components\Select::make('medicine_manufacturer_id')
                    ->label('Manufacturer')
                    ->relationship('manufacturer', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')->required()->unique('medicine_manufacturers', 'name'),
                    ]),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('₹'),
                TextInput::make('stock_quantity')
                    ->label('Available Stock')
                    ->required()
                    ->numeric(),
                DatePicker::make('expiry_date')
                    ->required()
                    ->default(now())
                    ->native(false),
            ])
            ->columns(2);
    }
}
