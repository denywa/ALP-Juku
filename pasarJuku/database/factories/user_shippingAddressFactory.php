<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\shippingAddress;
use App\Models\user_shippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class user_shippingAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = user_shippingAddress::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'userID' => User::factory(), // Menghubungkan dengan factory User
            'shippingAddressID' => shippingAddress::factory(), // Menghubungkan dengan factory ShippingAddress
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
