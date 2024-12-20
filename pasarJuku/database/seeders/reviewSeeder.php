<?php

namespace Database\Seeders;

use App\Models\review;
use Illuminate\Database\Seeder;

class reviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        review::factory()->count(10)->create();
    }
}
