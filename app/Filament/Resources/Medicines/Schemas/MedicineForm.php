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
                TextInput::make('category')
                    ->required()
                    ->placeholder('Analgesic / Antipyretic'),
                TextInput::make('manufacturer')
                    ->required()
                    ->placeholder('Cipla / GSK'),
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
