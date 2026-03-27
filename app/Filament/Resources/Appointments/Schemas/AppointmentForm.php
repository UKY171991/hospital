<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Support\Icons\Heroicon;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),

                Section::make('Booking Details')
                    ->description('Select the patient and doctor for this clinical encounter.')
                    ->icon(Heroicon::OutlinedCalendarDays)
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('patient_id')
                                    ->label('Patient')
                                    ->relationship('patient', 'name')
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(1)
                                    ->preload(),
                                Select::make('doctor_id')
                                    ->label('Preferred Doctor')
                                    ->relationship('doctor', 'name')
                                    ->required()
                                    ->searchable()
                                    ->columnSpan(1)
                                    ->preload(),
                                Select::make('status')
                                    ->options([
                                        'scheduled' => 'Scheduled',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required()
                                    ->default('scheduled')
                                    ->columnSpan(1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('appointment_date')
                                    ->label('Visit Date & Time')
                                    ->required()
                                    ->seconds(false)
                                    ->native(false)
                                    ->displayFormat('d M, Y - h:i A')
                                    ->prefixIcon(Heroicon::OutlinedClock)
                                    ->columnSpan(1),
                                
                                Textarea::make('reason')
                                    ->label('Reason for Visit')
                                    ->placeholder('e.g., Follow-up for fever and headache')
                                    ->rows(3)
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }
}
