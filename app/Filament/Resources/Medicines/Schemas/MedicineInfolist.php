<?php

namespace App\Filament\Resources\Medicines\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MedicineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('category'),
                TextEntry::make('manufacturer'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('stock_quantity')
                    ->numeric(),
                TextEntry::make('expiry_date')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
