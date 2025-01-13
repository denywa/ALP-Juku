<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Ikan Mas'],
            ['category_name' => 'Ikan Nila'],
            ['category_name' => 'Ikan Lele'],
            ['category_name' => 'Ikan Patin'],
            ['category_name' => 'Ikan Gurame'],
            ['category_name' => 'Ikan Mujair'],
            ['category_name' => 'Ikan Gabus'],
            ['category_name' => 'Ikan Bawal'],
            ['category_name' => 'Udang Air Tawar'],
            ['category_name' => 'Teri Air Tawar'],
            ['category_name' => 'Belut'],
        ];
        foreach ($categories as $category) {
            category::create($category);
        }
    }
}