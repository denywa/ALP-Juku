<?php

namespace Database\Factories;

use App\Models\order;
use App\Models\product;
use App\Models\user_shippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class orderfactory extends Factory
{
    protected $model = order::class;

    public function definition()
    {
        return [
            'user_shippingAddressID' => user_shippingAddress::factory(), // ID acak dari user_shippingAddress
            'order_status' => $this->faker->randomElement(['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled']), // Status acak
            'created_at' => now(), // Tanggal pembuatan
            'updated_at' => now(), // Tanggal pembaruan
        ];
    }
}