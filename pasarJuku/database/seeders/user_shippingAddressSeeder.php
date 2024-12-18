<?php

namespace Database\Seeders;


use App\Models\user_shippingAddress;
use Illuminate\Database\Seeder;

class user_shippingAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        user_shippingAddress::factory()->count(10)->create();
    }
}
