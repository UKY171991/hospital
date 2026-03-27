<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Department;
use App\Models\OpdVisit;
use App\Models\Prescription;
use App\Models\Bill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles
        $masterRole = Role::create([
            'name' => 'Master',
            'permissions' => ['view_doctors', 'create_doctors', 'edit_doctors', 'delete_doctors', 'view_patients', 'create_patients', 'edit_patients', 'delete_patients'],
            'view_all_records' => true,
        ]);

        $adminRole = Role::create(['name' => 'Admin']);
        $staffRole = Role::create(['name' => 'Staff']);

        // 2. Critical Users
        User::create([
            'name' => 'System Master',
            'email' => 'master@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'master',
            'role_id' => $masterRole->id,
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Reception Staff',
            'email' => 'staff@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'role_id' => $staffRole->id,
        ]);

        // 3. Departments
        $cardiology = Department::create(['name' => 'Cardiology', 'description' => 'Heart and blood pressure care.']);
        $neurology = Department::create(['name' => 'Neurology', 'description' => 'Brain and nervous system specialists.']);
        $pediatrics = Department::create(['name' => 'Pediatrics', 'description' => 'Children healthcare.']);

        // 4. Doctors
        $doctors = [
            [
                'name' => 'Dr. Arjun Mehta',
                'email' => 'arjun@hospital.com',
                'phone' => '9876543210',
                'department_id' => $cardiology->id,
                'consultation_fee' => 500.00,
                'qualification' => 'MD, Cardiologist',
                'specialization' => 'Interventional Cardiology',
                'opd_timing' => '10:00 AM - 04:00 PM',
            ],
            [
                'name' => 'Dr. Sara Khan',
                'email' => 'sara@hospital.com',
                'phone' => '9876543211',
                'department_id' => $neurology->id,
                'consultation_fee' => 700.00,
                'qualification' => 'DM, Neurologist',
                'specialization' => 'Neuro-rehabilitation',
                'opd_timing' => '11:00 AM - 05:00 PM',
            ],
            [
                'name' => 'Dr. Rahul Varma',
                'email' => 'rahul@hospital.com',
                'phone' => '9876543212',
                'department_id' => $pediatrics->id,
                'consultation_fee' => 300.00,
                'qualification' => 'MBBS, DCH',
                'specialization' => 'Child Nutrition',
                'opd_timing' => '09:00 AM - 02:00 PM',
            ],
        ];

        foreach ($doctors as $doc) {
            Doctor::create($doc);
        }

        // 5. Patients
        $patients = [
            ['name' => 'Ramesh Kumar', 'phone' => '9000000001', 'dob' => '1985-05-15', 'gender' => 'Male', 'blood_group' => 'O+', 'address' => '123, MG Road, Pune'],
            ['name' => 'Anita Sharma', 'phone' => '9000000002', 'dob' => '1992-08-22', 'gender' => 'Female', 'blood_group' => 'A+', 'address' => '45, Civil Lines, Jaipur'],
            ['name' => 'Vijay Singh', 'phone' => '9000000003', 'dob' => '1970-11-05', 'gender' => 'Male', 'blood_group' => 'B+', 'address' => '89, Station Road, Delhi'],
        ];

        foreach ($patients as $pat) {
            Patient::create($pat);
        }

        // 6. OPD Visits & Transactions
        $allPatients = Patient::all();
        $allDoctors = Doctor::all();
        
        $token = 101;
        foreach ($allPatients as $patient) {
            $doctor = $allDoctors->random();
            $visit = OpdVisit::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'symptoms' => 'Severe headache and mild dizziness.',
                'visit_date' => now()->toDateString(),
                'token_no' => 'TKN-' . $token++,
                'status' => 'completed',
            ]);

            // Prescription
            Prescription::create([
                'opd_visit_id' => $visit->id,
                'medicine_name' => 'Paracetamol 500mg',
                'dosage' => '1-0-1',
                'duration' => '3 Days',
                'notes' => 'Take after meals.',
            ]);

            // Bill
            Bill::create([
                'patient_id' => $patient->id,
                'opd_visit_id' => $visit->id,
                'total_amount' => $doctor->consultation_fee,
                'discount' => 0,
                'payment_status' => 'paid',
                'payment_mode' => 'Cash',
            ]);
        }
    }
}
