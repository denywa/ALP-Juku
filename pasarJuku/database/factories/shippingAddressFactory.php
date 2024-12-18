<?php

namespace Database\Factories;

use App\Models\shippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class shippingAddressFactory extends Factory
{
    protected $model = shippingAddress::class;

    public function definition()
    {
        return [
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'pos_code' => $this->faker->randomNumber(5, true), // 5 digit kode pos
            'recipient_name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}