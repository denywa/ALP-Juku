<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\businessProfile;

class businessProfilefactory extends Factory
{
    protected $model = businessProfile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'userID' => User::factory(), // ID user, sesuaikan dengan data user yang ada
            'business_name' => $this->faker->company(), // Nama bisnis acak
            'business_address' => $this->faker->address(), // Alamat bisnis acak
            'SIUP' => $this->faker->numerify('SIUP###-###'), // Format acak untuk SIUP
            'bank_account' => $this->faker->bankAccountNumber(), // Nomor rekening bank acak
            'verified_status' => $this->faker->randomElement([0, 1]), // Status verifikasi (0 = belum, 1 = sudah)
        ];
    }
}
