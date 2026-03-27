<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->placeholder('Jane Doe'),
                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->placeholder('+1 (234) 567-890'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->placeholder('jane@example.com'),
                DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                TextInput::make('gender')
                    ->required(),
                TextInput::make('blood_group')
                    ->placeholder('O+'),
                Textarea::make('address')
                    ->columnSpanFull()
                    ->rows(3),
            ])
            ->columns(2);
    }
}
