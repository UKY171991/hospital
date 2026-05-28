<?php

namespace App\Filament\Resources\Doctors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Doctor Information')
                    ->description('Professional and contact details')
                    ->icon(Heroicon::OutlinedUser)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Dr. John Doe')
                            ->prefixIcon(Heroicon::OutlinedUser),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->prefixIcon(Heroicon::OutlinedAtSymbol),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->prefixIcon(Heroicon::OutlinedPhone),
                        \Filament\Forms\Components\Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Service Details')
                    ->icon(Heroicon::OutlinedBriefcase)
                    ->schema([
                        TextInput::make('consultation_fee')
                            ->required()
                            ->numeric()
                            ->prefix('₹')
                            ->placeholder('500'),
                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required()
                            ->default('active')
                            ->native(false),
                    ])->columns(2),

                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
            ]);
    }
}
