<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hospitals')->insert([
            [
                'logo' => null,
                'userid' => 'ThiDemo1',
                'password' => '9876543210',
                'passcode' => '1234',
                'name' => 'HEALTHCARE HOSPITAL',
                'contact_no' => '7836910002',
                'pan_no' => 'CYPPS4987P',
                'address' => 'Plot No 199 Sector -28 Faridabad Haryana-121002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
