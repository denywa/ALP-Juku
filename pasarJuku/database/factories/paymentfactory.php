<?php

namespace Database\Factories;

use App\Models\payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class paymentfactory extends Factory
{
    protected $model = payment::class;

    public function definition()
    {
        return [
            'payment_type' => $this->faker->randomElement(['GOPAY', 'OVO', 'DANA', 'BCA']), // Status acak
        ];
    }
}