<?php

namespace Database\Factories;

use App\Models\order;
use App\Models\order_item;
use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

class order_itemFactory extends Factory
{
    protected $model = order_item::class;

    public function definition()
    {
        return [
            'productID' => product::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'orderID' => order::factory(),
        ];
    }
}