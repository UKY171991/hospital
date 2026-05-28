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
                \Filament\Forms\Components\Section::make('Medicine Details')
                    ->description('General information about the medicine')
                    ->icon(\Filament\Support\Icons\Heroicon::OutlinedBeaker)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Paracetamol 500mg')
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedShoppingBag),
                        \Filament\Forms\Components\Select::make('medicine_category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->createOptionForm([
                                TextInput::make('name')->required()->unique('medicine_categories', 'name'),
                            ]),
                        \Filament\Forms\Components\Select::make('medicine_manufacturer_id')
                            ->label('Manufacturer')
                            ->relationship('manufacturer', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->createOptionForm([
                                TextInput::make('name')->required()->unique('medicine_manufacturers', 'name'),
                            ]),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Inventory & Pricing')
                    ->icon(\Filament\Support\Icons\Heroicon::OutlinedCalculator)
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('₹')
                            ->placeholder('50.00'),
                        TextInput::make('stock_quantity')
                            ->label('Available Stock')
                            ->required()
                            ->numeric()
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedArchiveBox),
                        DatePicker::make('expiry_date')
                            ->required()
                            ->default(now()->addYear())
                            ->native(false)
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedCalendar),
                    ])->columns(3),
            ]);
    }
}
