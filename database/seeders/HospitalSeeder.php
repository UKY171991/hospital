<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;
use App\Models\User; // Ensure User model is imported

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the first user to associate with the hospital
        // If no user exists, create one.
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Unique identifier to find the user
            [ // Attributes to use if creating a new user
                'name' => 'Default Admin User',
                'password' => bcrypt('password') // Hash the password
            ]
        );

        // Check if a hospital already exists to avoid duplicates if seeder is run multiple times
        if (Hospital::count() == 0) {
            // Manually create a Hospital instance
            Hospital::create([
                'name' => 'Default Hospital',
                'contact_no' => '1234567890',
                'pan_no' => 'ABCDE1234F',
                'address' => '123 Main St',
                'email' => 'hospital@example.com',
                'userid' => $user->id,
                'password' => bcrypt('hospitalpassword'),
                'passcode' => '1234', // Ensure this matches the type in your migration if it's numeric
                'tag_line' => 'Caring for you.',
                'bank_name' => 'Community Bank',
                'branch_name' => 'Downtown Branch',
                'ifsc_code' => 'CBIN0123456',
                'account_no' => '123456789012',
                'gstin_no' => '07AAFCH1234A1Z5',
                'cin_no' => 'U12345XX2023PTC012345',
                'prefix' => 'HSP',
                // Add other fields as necessary, ensuring they match your 'hospitals' table schema
                // 'logo' => null,
                // 'signature' => null,
                // 'stamp' => null,
                // 'payment_qr' => null,
            ]);
        }
    }
}
