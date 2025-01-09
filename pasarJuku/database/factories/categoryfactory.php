<?php

namespace Database\Factories;

use App\Models\category;
use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

class categoryfactory extends Factory
{
    protected $model = category::class;

    public function definition()
    {
        return [
            'category_name' => $this->faker->randomElement(['Ikan Nila', 'Ikan Mas', 'Ikan Bolu', 'Ikan Bawal', 'Ikan Bolu', 'Ikan Mujair', 'Ikan Lele', 'Belut', 'Ikan Teri', 'Udang']),
        ];
    }
}