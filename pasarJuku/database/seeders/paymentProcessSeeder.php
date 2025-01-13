<?php

namespace Database\Seeders;

use App\Models\payment_process;
use Illuminate\Database\Seeder;

class paymentProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        payment_process::factory()->count(10)->create();
    }
}