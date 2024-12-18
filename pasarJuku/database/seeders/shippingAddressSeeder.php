<?php

namespace Database\Seeders;

use App\Models\shippingAddress;
use Illuminate\Database\Seeder;

class shippingAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        shippingAddress::factory()->count(10)->create();
    }
}
