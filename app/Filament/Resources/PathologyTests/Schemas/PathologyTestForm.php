<?php

namespace App\Filament\Resources\PathologyTests\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;

class PathologyTestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Test Details')
                    ->description('Identify the test name and its clinical category.')
                    ->icon(Heroicon::OutlinedClipboardDocumentList)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('test_name')
                                    ->label('Name of Test')
                                    ->required()
                                    ->placeholder('e.g., Complete Blood Count (CBC)')
                                    ->columnSpan(1),
                                TextInput::make('category')
                                    ->label('Clinical Category')
                                    ->required()
                                    ->placeholder('e.g., Hematology')
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Pricing & References')
                    ->description('Manage the cost and clinical benchmarks for this test.')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label('Standard Price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('₹')
                                    ->placeholder('0.00')
                                    ->columnSpan(1),
                                Textarea::make('normal_range')
                                    ->label('Reference Normal Range')
                                    ->placeholder('e.g., Hemoglobin: 13.5-17.5 g/dL')
                                    ->rows(3)
                                    ->columnSpan(2),
                            ]),
                    ]),
            ]);
    }
}
