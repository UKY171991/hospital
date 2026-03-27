<?php

namespace App\Filament\Resources\PathologyRecords;

use App\Filament\Resources\PathologyRecords\Pages\CreatePathologyRecord;
use App\Filament\Resources\PathologyRecords\Pages\EditPathologyRecord;
use App\Filament\Resources\PathologyRecords\Pages\ListPathologyRecords;
use App\Filament\Resources\PathologyRecords\Pages\ViewPathologyRecord;
use App\Filament\Resources\PathologyRecords\Schemas\PathologyRecordForm;
use App\Filament\Resources\PathologyRecords\Schemas\PathologyRecordInfolist;
use App\Filament\Resources\PathologyRecords\Tables\PathologyRecordsTable;
use App\Models\PathologyRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PathologyRecordResource extends Resource
{
    protected static ?string $model = PathologyRecord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static string|\UnitEnum|null $navigationGroup = 'Pathology';
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->check() && !auth()->user()->canSeeAllRecords()) {
            $query->where('user_id', auth()->id());
        }
        return $query;
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PathologyRecordForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PathologyRecordInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PathologyRecordsTable::configure($table);
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
            'index' => ListPathologyRecords::route('/'),
            'create' => CreatePathologyRecord::route('/create'),
            'view' => ViewPathologyRecord::route('/{record}'),
            'edit' => EditPathologyRecord::route('/{record}/edit'),
        ];
    }
}
