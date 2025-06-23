<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'name' => 'Dr. John Smith',
                'employee_id' => 'EMP001',
                'mobile_no' => '9876543210',
                'email' => 'john.smith@hospital.com',
                'current_address' => '123 Main Street, City',
                'role' => 'Doctor',
                'department' => 'Cardiology',
                'salary_per_day' => 5000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nurse Jane Doe',
                'employee_id' => 'EMP002',
                'mobile_no' => '9876543211',
                'email' => 'jane.doe@hospital.com',
                'current_address' => '456 Oak Avenue, City',
                'role' => 'Nurse',
                'department' => 'General',
                'salary_per_day' => 2000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Sarah Wilson',
                'employee_id' => 'EMP003',
                'mobile_no' => '9876543212',
                'email' => 'sarah.wilson@hospital.com',
                'current_address' => '789 Pine Road, City',
                'role' => 'Administrator',
                'department' => 'Administration',
                'salary_per_day' => 3000,
                'status' => 'Inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
