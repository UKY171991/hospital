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
                \Filament\Forms\Components\Section::make('Sale Details')
                    ->description('Select patient and medicine for the sale')
                    ->icon(\Filament\Support\Icons\Heroicon::OutlinedShoppingCart)
                    ->schema([
                        \Filament\Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedUser),
                        \Filament\Forms\Components\Select::make('medicine_id')
                            ->relationship('medicine', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $medicine = \App\Models\Medicine::find($state);
                                if ($medicine) {
                                    $set('unit_price', $medicine->price);
                                }
                            })
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedBeaker),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Transaction')
                    ->icon(\Filament\Support\Icons\Heroicon::OutlinedCurrencyDollar)
                    ->schema([
                        TextInput::make('unit_price')
                            ->disabled()
                            ->dehydrated(false)
                            ->numeric()
                            ->prefix('₹')
                            ->label('Price per unit'),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(function (callable $set, callable $get, $state) {
                                $unitPrice = $get('unit_price');
                                if ($unitPrice && $state) {
                                    $set('total_amount', $unitPrice * $state);
                                }
                            })
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedHashtag),
                        TextInput::make('total_amount')
                            ->required()
                            ->numeric()
                            ->prefix('₹')
                            ->readOnly()
                            ->helperText('Calculated automatically'),
                        DatePicker::make('sale_date')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedCalendar),
                    ])->columns(4),
            ]);
    }
}
