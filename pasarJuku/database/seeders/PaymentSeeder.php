<?php

namespace Database\Seeders;

use App\Models\payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        payment::factory()->count(10)->create();
    }
}
