<?php

namespace Database\Seeders;

use App\Models\product;
use Illuminate\Database\Seeder;

class productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        product::factory()->count(10)->create();
    }
}
