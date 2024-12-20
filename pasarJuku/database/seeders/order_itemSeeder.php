<?php

namespace Database\Seeders;

use App\Models\order_item;
use Illuminate\Database\Seeder;

class order_itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        order_item::factory()->count(10)->create();
    }
}