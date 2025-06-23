<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Hospital;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Room;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\IncomeExpense;
use App\Models\IncomeCategory;
use App\Models\IncomeItem;
use Carbon\Carbon;

class DashboardSampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample doctors
        for ($i = 1; $i <= 10; $i++) {
            Doctor::firstOrCreate(['doctor_id' => 'DOC' . str_pad($i, 3, '0', STR_PAD_LEFT)], [
                'name' => 'Dr. Doctor ' . $i,
                'mobile' => '555-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'email' => 'doctor' . $i . '@hospital.com',
                'address' => $i . ' Medical Street',
                'joining_date' => Carbon::now()->subDays(rand(30, 365)),
                'opening_balance' => rand(10000, 50000),
                'status' => 'Active'
            ]);
        }

        // Create sample patients
        for ($i = 1; $i <= 25; $i++) {
            Patient::firstOrCreate(['patient_id' => 'PAT' . str_pad($i, 4, '0', STR_PAD_LEFT)], [
                'name' => 'Patient ' . $i,
                'mobile' => '555-' . str_pad($i + 1000, 4, '0', STR_PAD_LEFT),
                'address' => $i . ' Patient Street',
                'age' => rand(18, 80),
                'gender' => rand(0, 1) ? 'Male' : 'Female',
                'blood_group' => ['A+', 'B+', 'O+', 'AB+'][rand(0, 3)],
                'status' => 'Active'
            ]);
        }

        // Create sample wards and beds
        for ($i = 1; $i <= 5; $i++) {
            $ward = Ward::firstOrCreate(['name' => 'Ward ' . $i]);
            
            for ($j = 1; $j <= 10; $j++) {
                Bed::firstOrCreate(['bed_no' => 'W' . $i . 'B' . str_pad($j, 2, '0', STR_PAD_LEFT)], [
                    'bed_type' => ['General', 'ICU', 'Private'][rand(0, 2)],
                    'status' => rand(0, 3) ? 'Available' : 'Occupied'
                ]);
            }
        }

        // Create income item first
        $incomeItem = IncomeItem::firstOrCreate(['name' => 'Consultation Fee'], [
            'description' => 'Doctor consultation fee',
            'amount' => 500
        ]);

        // Create sample payments and receipts
        for ($i = 1; $i <= 10; $i++) {
            Payment::create([
                'select_type' => 'Doctor',
                'date' => Carbon::now()->subDays(rand(0, 30)),
                'payment_ref_no' => 'PAY' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'before_due_amount' => rand(5000, 15000),
                'discount' => rand(0, 1000),
                'paid_amount' => rand(4000, 12000),
                'after_due_amount' => rand(0, 3000),
                'payment_mode' => 'Cash'
            ]);

            Receipt::create([
                'select_type' => 'Patient',
                'date' => Carbon::now()->subDays(rand(0, 30)),
                'receipt_ref_no' => 'REC' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'before_due_amount' => rand(3000, 10000),
                'discount' => rand(0, 500),
                'receipt_amount' => rand(2500, 8000),
                'after_due_amount' => rand(0, 2000),
                'receipt_mode' => 'Cash'
            ]);
        }

        // Create sample income/expense entries
        for ($i = 1; $i <= 15; $i++) {
            IncomeExpense::create([
                'date' => Carbon::now()->subDays(rand(0, 30)),
                'type' => rand(0, 1) ? 'Income' : 'Expenses',
                'category' => 'Medical Services',
                'item_id' => $incomeItem->id,
                'amount' => rand(1000, 10000),
                'description' => 'Sample entry'
            ]);
        }

        echo "Sample data created successfully!\n";
    }
}
