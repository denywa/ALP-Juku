<?php

namespace Database\Factories;

use App\Models\order_item;
use App\Models\review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class reviewFactory extends Factory
{
    protected $model = review::class;

    public function definition()
    {
        return [
            'userID' => User::factory(), // Ambil userID yang valid dari tabel users
            'order_itemID' => order_item::inRandomOrder()->first()->order_itemID, // Ambil order_itemID yang valid dari tabel order_items
            'rating' => $this->faker->numberBetween(1, 5), // Rating antara 1 hingga 5
            'comment' => $this->faker->optional()->sentence(), // Komentar opsional
        ];
    }
}