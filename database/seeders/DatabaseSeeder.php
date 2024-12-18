<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // $this->call([
        //     BookSeeder::class,
        // ]);

        User::factory(10)->create();
    }
}
