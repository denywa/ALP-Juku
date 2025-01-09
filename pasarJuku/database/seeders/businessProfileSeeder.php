<?php

namespace Database\Seeders;

use App\Models\businessProfile;
use Illuminate\Database\Seeder;

class businessProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        businessProfile::factory()->count(10)->create();
    }
}
