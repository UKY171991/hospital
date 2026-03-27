<?php

namespace App\Filament\Resources\PathologyTests;

use App\Filament\Resources\PathologyTests\Pages\CreatePathologyTest;
use App\Filament\Resources\PathologyTests\Pages\EditPathologyTest;
use App\Filament\Resources\PathologyTests\Pages\ListPathologyTests;
use App\Filament\Resources\PathologyTests\Pages\ViewPathologyTest;
use App\Filament\Resources\PathologyTests\Schemas\PathologyTestForm;
use App\Filament\Resources\PathologyTests\Schemas\PathologyTestInfolist;
use App\Filament\Resources\PathologyTests\Tables\PathologyTestsTable;
use App\Models\PathologyTest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PathologyTestResource extends Resource
{
    protected static ?string $model = PathologyTest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;
    protected static string|\UnitEnum|null $navigationGroup = 'Pathology';

    protected static ?string $recordTitleAttribute = 'test_name';

    public static function form(Schema $schema): Schema
    {
        return PathologyTestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PathologyTestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PathologyTestsTable::configure($table);
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
            'index' => ListPathologyTests::route('/'),
            'create' => CreatePathologyTest::route('/create'),
            'view' => ViewPathologyTest::route('/{record}'),
            'edit' => EditPathologyTest::route('/{record}/edit'),
        ];
    }
}
