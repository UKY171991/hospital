<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                \Filament\Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                \Filament\Forms\Components\Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                DateTimePicker::make('appointment_date')
                    ->required()
                    ->native(false),
                TextInput::make('status')
                    ->required()
                    ->default('scheduled')
                    ->placeholder('scheduled/completed/cancelled'),
                Textarea::make('reason')
                    ->columnSpanFull()
                    ->rows(3),
            ])
            ->columns(2);
    }
}
