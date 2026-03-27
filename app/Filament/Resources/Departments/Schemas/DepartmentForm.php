<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Cardiology / Orthopedics'),
                TextInput::make('status')
                    ->required()
                    ->default('active')
                    ->placeholder('active/inactive'),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->rows(3)
                    ->placeholder('Enter department purpose and services...'),
            ])
            ->columns(2);
    }
}
