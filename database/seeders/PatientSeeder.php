<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patients')->insert([
            [
                'name' => 'John Doe',
                'patient_id' => 'P1001',
                'relation_name' => 'Jane Doe',
                'mobile' => '9876543210',
                'reg_date' => '2024-05-27',
                'address' => '123 Main St',
                'status' => 'Active',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alice Smith',
                'patient_id' => 'P1002',
                'relation_name' => 'Bob Smith',
                'mobile' => '9123456780',
                'reg_date' => '2024-05-26',
                'address' => '456 Oak Ave',
                'status' => 'Inactive',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Charlie Brown',
                'patient_id' => 'P1003',
                'relation_name' => 'Lucy Brown',
                'mobile' => '9988776655',
                'reg_date' => '2024-05-25',
                'address' => '789 Pine Rd',
                'status' => 'Active',
                'photo' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 