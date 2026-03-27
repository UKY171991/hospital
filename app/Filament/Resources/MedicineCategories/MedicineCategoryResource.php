<?php

namespace App\Filament\Resources\MedicineCategories;

use App\Filament\Resources\MedicineCategories\Pages\CreateMedicineCategory;
use App\Filament\Resources\MedicineCategories\Pages\EditMedicineCategory;
use App\Filament\Resources\MedicineCategories\Pages\ListMedicineCategories;
use App\Filament\Resources\MedicineCategories\Schemas\MedicineCategoryForm;
use App\Filament\Resources\MedicineCategories\Tables\MedicineCategoriesTable;
use App\Models\MedicineCategory;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MedicineCategoryResource extends Resource
{
    protected static ?string $model = MedicineCategory::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static string|\UnitEnum|null $navigationGroup = 'Pharmacy';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?int $navigationSort = 3;

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return MedicineCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicineCategoriesTable::configure($table);
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
            'index' => ListMedicineCategories::route('/'),
            'create' => CreateMedicineCategory::route('/create'),
            'edit' => EditMedicineCategory::route('/{record}/edit'),
        ];
    }
}
