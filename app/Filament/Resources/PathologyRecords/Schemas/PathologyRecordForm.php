<?php

namespace App\Filament\Resources\PathologyRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PathologyRecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Record Details')
                    ->description('Test and patient association')
                    ->icon(\Filament\Support\Icons\Heroicon::OutlinedBeaker)
                    ->schema([
                        \Filament\Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedUser),
                        \Filament\Forms\Components\Select::make('pathology_test_id')
                            ->label('Test Type')
                            ->relationship('pathologyTest', 'test_name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedClipboardDocumentList),
                        \Filament\Forms\Components\Select::make('doctor_id')
                            ->label('Referred By')
                            ->relationship('doctor', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedUserCircle),
                        DatePicker::make('test_date')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->prefixIcon(\Filament\Support\Icons\Heroicon::OutlinedCalendar),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Results & Status')
                    ->schema([
                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'reported' => 'Reported',
                            ])
                            ->required()
                            ->default('pending')
                            ->native(false),
                        Textarea::make('result')
                            ->columnSpanFull()
                            ->rows(5)
                            ->placeholder('Enter test results here...'),
                    ]),

                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
            ]);
    }
}
