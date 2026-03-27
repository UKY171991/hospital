<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Models\Role;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedLockClosed;
    protected static string|\UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(12)
                ->schema([
                    Section::make('Type Info')
                        ->schema([
                            TextInput::make('name')
                                ->label('Type Name')
                                ->required()
                                ->unique(ignoreRecord: true),
                            Select::make('status')
                                ->options([
                                    'Active' => 'Active',
                                    'Inactive' => 'Inactive',
                                ])
                                ->default('Active')
                                ->required(),
                            Checkbox::make('view_all_records')
                                ->label('View All Data')
                                ->inline(true),
                        ])
                        ->columnSpan(3),

                    Section::make('Page Permissions')
                        ->schema([
                            ViewField::make('permissions_table')
                                ->view('filament.forms.components.permission-table')
                                ->columnSpanFull(),
                        ])
                        ->columnSpan(9),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            \Filament\Tables\Columns\TextColumn::make('name')
                ->label('Type Name')
                ->searchable()
                ->sortable(),
            \Filament\Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => $state === 'Active' ? 'success' : 'danger'),
            \Filament\Tables\Columns\IconColumn::make('view_all_records')
                ->label('All Data')
                ->boolean(),
            \Filament\Tables\Columns\TextColumn::make('users_count')
                ->counts('users')
                ->label('Users'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
