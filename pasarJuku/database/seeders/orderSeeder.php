<?php

namespace Database\Seeders;

use App\Models\order;
use Illuminate\Database\Seeder;

class orderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        order::factory()->count(10)->create();
    }
}
