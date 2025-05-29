<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('opds')->insert([
            [
                'opd_type' => 'General',
                'opd_no' => 'OPD1001',
                'admission_date' => '2024-05-27',
                'patient_id' => 'P1001',
                'name' => 'John Doe',
                'doctor_name' => 'Dr. Smith',
                'disease' => 'Fever',
                'doctor_fee' => 500,
                'discount' => 50,
                'paid_amount' => 450,
                'due_amount' => 0,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'opd_type' => 'Specialist',
                'opd_no' => 'OPD1002',
                'admission_date' => '2024-05-26',
                'patient_id' => 'P1002',
                'name' => 'Alice Smith',
                'doctor_name' => 'Dr. Brown',
                'disease' => 'Cough',
                'doctor_fee' => 700,
                'discount' => 100,
                'paid_amount' => 600,
                'due_amount' => 100,
                'status' => 'Inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 