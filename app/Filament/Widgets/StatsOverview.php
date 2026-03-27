<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MedicineSale;
use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Doctors', Doctor::count())
                ->description('Active medical staff')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            Stat::make('Total Patients', Patient::count())
                ->description('Registered records')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Today\'s Appointments', Appointment::whereDate('appointment_date', today())->count())
                ->description('Scheduled visits')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),
            Stat::make('Pharmacy Sales', '₹' . number_format(MedicineSale::sum('total_price'), 2))
                ->description('Total revenue')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
        ];
    }
}
