<?php

namespace Database\Seeders;

use App\Models\payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            ['payment_type' => 'GoPay'],
            ['payment_type' => 'OVO'],
            ['payment_type' => 'DANA'],
            ['payment_type' => 'BCA'],
        ];

        foreach ($payments as $payment) {
            payment::create($payment);
        }
    }
}
