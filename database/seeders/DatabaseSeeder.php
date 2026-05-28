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
use App\Models\Appointment;
use App\Models\PathologyTest;
use App\Models\PathologyRecord;
use App\Models\MedicineCategory;
use App\Models\MedicineManufacturer;
use App\Models\Medicine;
use App\Models\MedicineSale;
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
        $cardiology = Department::create(['name' => 'Cardiology', 'description' => 'Heart and blood pressure care.', 'status' => 'active']);
        $neurology = Department::create(['name' => 'Neurology', 'description' => 'Brain and nervous system specialists.', 'status' => 'active']);
        $pediatrics = Department::create(['name' => 'Pediatrics', 'description' => 'Children healthcare.', 'status' => 'active']);
        $orthopedics = Department::create(['name' => 'Orthopedics', 'description' => 'Bone and joint specialists.', 'status' => 'active']);

        // 4. Doctors
        $doctors = [
            [
                'name' => 'Dr. Arjun Mehta',
                'email' => 'arjun@hospital.com',
                'phone' => '9876543210',
                'department_id' => $cardiology->id,
                'consultation_fee' => 500.00,
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Sara Khan',
                'email' => 'sara@hospital.com',
                'phone' => '9876543211',
                'department_id' => $neurology->id,
                'consultation_fee' => 700.00,
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Rahul Varma',
                'email' => 'rahul@hospital.com',
                'phone' => '9876543212',
                'department_id' => $pediatrics->id,
                'consultation_fee' => 300.00,
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Priya Singh',
                'email' => 'priya@hospital.com',
                'phone' => '9876543213',
                'department_id' => $orthopedics->id,
                'consultation_fee' => 450.00,
                'status' => 'active',
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
            ['name' => 'Sneha Patil', 'phone' => '9000000004', 'dob' => '2000-02-10', 'gender' => 'Female', 'blood_group' => 'AB+', 'address' => '12, Link Road, Mumbai'],
        ];

        foreach ($patients as $pat) {
            Patient::create($pat);
        }

        $allPatients = Patient::all();
        $allDoctors = Doctor::all();

        // 6. Appointments
        foreach ($allPatients as $patient) {
            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $allDoctors->random()->id,
                'appointment_date' => now()->addDays(rand(1, 10))->setHour(rand(10, 16)),
                'reason' => 'Regular checkup',
                'status' => 'pending',
            ]);
        }

        // 7. OPD Visits, Prescriptions & Bills
        $token = 101;
        foreach ($allPatients as $patient) {
            $doctor = $allDoctors->random();
            $visit = OpdVisit::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'symptoms' => 'Fever and cold',
                'visit_date' => now()->subDays(rand(1, 5))->toDateString(),
                'token_no' => 'TKN-' . $token++,
                'status' => 'completed',
            ]);

            Prescription::create([
                'opd_visit_id' => $visit->id,
                'medicine_name' => 'Paracetamol 500mg',
                'dosage' => '1-0-1',
                'duration' => '3 Days',
                'notes' => 'Take after meals.',
            ]);

            Bill::create([
                'patient_id' => $patient->id,
                'opd_visit_id' => $visit->id,
                'total_amount' => $doctor->consultation_fee,
                'discount' => 0,
                'payment_status' => 'paid',
                'payment_mode' => 'Cash',
            ]);
        }

        // 8. Pathology
        $pathologyTests = [
            ['test_name' => 'CBC (Complete Blood Count)', 'category' => 'Blood', 'normal_range' => 'Hb: 12-16 g/dL', 'price' => 250.00],
            ['test_name' => 'Thyroid Profile (T3, T4, TSH)', 'category' => 'Hormone', 'normal_range' => 'TSH: 0.4-4.0 mIU/L', 'price' => 600.00],
            ['test_name' => 'Urine Routine', 'category' => 'Urine', 'normal_range' => 'Clear, Light Yellow', 'price' => 150.00],
        ];

        foreach ($pathologyTests as $test) {
            $createdTest = PathologyTest::create($test);
            
            // Assign to some patients
            $patient = $allPatients->random();
            PathologyRecord::create([
                'patient_id' => $patient->id,
                'pathology_test_id' => $createdTest->id,
                'doctor_id' => $allDoctors->random()->id,
                'test_date' => now()->subDays(rand(1, 10))->toDateString(),
                'result' => 'Normal results within range',
                'status' => 'completed',
            ]);
        }

        // 9. Pharmacy (Medicine Categories & Manufacturers)
        $categories = [
            ['name' => 'Antibiotics', 'description' => 'Used to treat bacterial infections.'],
            ['name' => 'Analgesics', 'description' => 'Pain relievers.'],
            ['name' => 'Antipyretics', 'description' => 'Used to reduce fever.'],
        ];

        foreach ($categories as $cat) {
            MedicineCategory::create($cat);
        }

        $manufacturers = [
            ['name' => 'Sun Pharma', 'contact_number' => '1234567890'],
            ['name' => 'Cipla', 'contact_number' => '1234567891'],
        ];

        foreach ($manufacturers as $mfg) {
            MedicineManufacturer::create($mfg);
        }

        $allCats = MedicineCategory::all();
        $allMfgs = MedicineManufacturer::all();

        $medicines = [
            ['name' => 'Amoxicillin', 'category' => 'Antibiotics', 'manufacturer' => 'Sun Pharma', 'price' => 12.50, 'stock_quantity' => 100, 'expiry_date' => '2027-12-31'],
            ['name' => 'Ibuprofen', 'category' => 'Analgesics', 'manufacturer' => 'Cipla', 'price' => 8.00, 'stock_quantity' => 200, 'expiry_date' => '2026-06-30'],
            ['name' => 'Paracetamol', 'category' => 'Antipyretics', 'manufacturer' => 'Sun Pharma', 'price' => 5.00, 'stock_quantity' => 500, 'expiry_date' => '2026-12-31'],
        ];

        foreach ($medicines as $med) {
            $cat = $allCats->where('name', $med['category'])->first();
            $mfg = $allMfgs->where('name', $med['manufacturer'])->first();

            $createdMed = Medicine::create([
                'name' => $med['name'],
                'medicine_category_id' => $cat->id,
                'medicine_manufacturer_id' => $mfg->id,
                'category' => $med['category'],
                'manufacturer' => $med['manufacturer'],
                'price' => $med['price'],
                'stock_quantity' => $med['stock_quantity'],
                'expiry_date' => $med['expiry_date'],
            ]);

            // Create some sales
            MedicineSale::create([
                'patient_id' => $allPatients->random()->id,
                'medicine_id' => $createdMed->id,
                'quantity' => rand(1, 5),
                'total_amount' => $createdMed->price * rand(1, 5),
                'sale_date' => now()->toDateString(),
            ]);
        }
    }
}
