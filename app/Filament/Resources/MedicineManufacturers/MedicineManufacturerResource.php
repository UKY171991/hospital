<?php

namespace App\Filament\Resources\MedicineManufacturers;

use App\Filament\Resources\MedicineManufacturers\Pages\CreateMedicineManufacturer;
use App\Filament\Resources\MedicineManufacturers\Pages\EditMedicineManufacturer;
use App\Filament\Resources\MedicineManufacturers\Pages\ListMedicineManufacturers;
use App\Filament\Resources\MedicineManufacturers\Schemas\MedicineManufacturerForm;
use App\Filament\Resources\MedicineManufacturers\Tables\MedicineManufacturersTable;
use App\Models\MedicineManufacturer;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MedicineManufacturerResource extends Resource
{
    protected static ?string $model = MedicineManufacturer::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-office';
    protected static string|\UnitEnum|null $navigationGroup = 'Pharmacy';
    protected static ?string $navigationLabel = 'Manufacturers';
    protected static ?int $navigationSort = 4;

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return MedicineManufacturerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicineManufacturersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedicineManufacturers::route('/'),
            'create' => CreateMedicineManufacturer::route('/create'),
            'edit' => EditMedicineManufacturer::route('/{record}/edit'),
        ];
    }
}
