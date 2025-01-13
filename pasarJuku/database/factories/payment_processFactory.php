<?php

namespace Database\Factories;

use App\Models\order;
use App\Models\payment;
use App\Models\payment_process;
use Illuminate\Database\Eloquent\Factories\Factory;

class payment_processFactory extends Factory
{
    protected $model = payment_process::class;

    public function definition()
    {
        return [
            'orderID' => order::factory(),
            'paymentID' => payment::factory(),
            'total_price' => $this->faker->randomNumber(5, true), // Menghasilkan harga acak 5 digit
            'payment_status' => $this->faker->randomElement(['pending', 'success']),
        ];
    }
}