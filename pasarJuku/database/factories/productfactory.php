<?php

namespace Database\Factories;

use App\Models\businessProfile;
use App\Models\category;
use App\Models\product;
use Illuminate\Database\Eloquent\Factories\Factory;

class productfactory extends Factory
{
    protected $model = product::class;

    public function definition()
    {
        return [
            'businessProfileID' => businessProfile::factory(),
            'name' => $this->faker->word(), // Nama produk, 1 kata acak
            'description' => $this->faker->sentence(), // Deskripsi produk, kalimat acak
            'price' => $this->faker->randomFloat(2, 100, 10000), // Harga produk, 2 desimal, rentang 100-10.000
            'stock' => $this->faker->numberBetween(1, 100), // Jumlah stok, 1-500 unit
            'categoryID' => category::factory(),
        ];
    }
}