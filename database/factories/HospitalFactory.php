<?php

namespace Database\Factories;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class HospitalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hospital::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'contact_no' => $this->faker->phoneNumber,
            'pan_no' => Str::random(10),
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'userid' => User::factory(), // Assumes a User factory exists and will create/get a user
            'password' => bcrypt('password'), // Default password, consider making this configurable
            'passcode' => Str::random(4),
            'tag_line' => $this->faker->sentence,
            'bank_name' => $this->faker->company . ' Bank',
            'branch_name' => $this->faker->streetName,
            'ifsc_code' => Str::random(11),
            'account_no' => $this->faker->bankAccountNumber,
            'gstin_no' => Str::random(15),
            'cin_no' => Str::random(21),
            'prefix' => Str::random(3),
            // Add other fields as necessary, for example:
            // 'logo' => null,
            // 'signature' => null,
            // 'stamp' => null,
            // 'payment_qr' => null,
        ];
    }
}
