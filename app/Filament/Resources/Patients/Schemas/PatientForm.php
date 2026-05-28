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
                \Filament\Forms\Components\Section::make('Personal Information')
                    ->description('Basic details of the patient')
                    ->icon(Heroicon::OutlinedUser)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Jane Doe')
                            ->prefixIcon(Heroicon::OutlinedUser),
                        DatePicker::make('dob')
                            ->label('Date of Birth')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/M/Y')
                            ->prefixIcon(Heroicon::OutlinedCalendar),
                        \Filament\Forms\Components\Select::make('gender')
                            ->options([
                                'Male' => 'Male',
                                'Female' => 'Female',
                                'Other' => 'Other',
                            ])
                            ->required()
                            ->native(false),
                        \Filament\Forms\Components\Select::make('blood_group')
                            ->options([
                                'A+' => 'A+', 'A-' => 'A-',
                                'B+' => 'B+', 'B-' => 'B-',
                                'AB+' => 'AB+', 'AB-' => 'AB-',
                                'O+' => 'O+', 'O-' => 'O-',
                            ])
                            ->searchable()
                            ->placeholder('Select Group')
                            ->native(false),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Contact Information')
                    ->description('How to reach the patient')
                    ->icon(Heroicon::OutlinedPhone)
                    ->schema([
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->placeholder('+1 (234) 567-890')
                            ->prefixIcon(Heroicon::OutlinedPhone),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->placeholder('jane@example.com')
                            ->prefixIcon(Heroicon::OutlinedAtSymbol),
                        Textarea::make('address')
                            ->columnSpanFull()
                            ->rows(3),
                    ])->columns(2),

                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
            ]);
    }
}
