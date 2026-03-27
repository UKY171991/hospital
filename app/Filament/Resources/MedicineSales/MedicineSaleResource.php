<?php

namespace App\Filament\Resources\MedicineSales;

use App\Filament\Resources\MedicineSales\Pages\CreateMedicineSale;
use App\Filament\Resources\MedicineSales\Pages\EditMedicineSale;
use App\Filament\Resources\MedicineSales\Pages\ListMedicineSales;
use App\Filament\Resources\MedicineSales\Pages\ViewMedicineSale;
use App\Filament\Resources\MedicineSales\Schemas\MedicineSaleForm;
use App\Filament\Resources\MedicineSales\Schemas\MedicineSaleInfolist;
use App\Filament\Resources\MedicineSales\Tables\MedicineSalesTable;
use App\Models\MedicineSale;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MedicineSaleResource extends Resource
{
    protected static ?string $model = MedicineSale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return MedicineSaleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MedicineSaleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicineSalesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedicineSales::route('/'),
            'create' => CreateMedicineSale::route('/create'),
            'view' => ViewMedicineSale::route('/{record}'),
            'edit' => EditMedicineSale::route('/{record}/edit'),
        ];
    }
}
