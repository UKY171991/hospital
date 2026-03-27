<?php

namespace App\Filament\Resources\MedicineSales\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MedicineSaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('medicine_id')
                    ->relationship('medicine', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->prefix('₹'),
                DatePicker::make('sale_date')
                    ->required()
                    ->native(false),
            ])
            ->columns(2);
    }
}
