<?php

namespace Database\Seeders;

use App\Models\Category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Alimentation', 'Transport', 'Loisirs', 'Santé', 'Logement', 'Vêtements', 'Éducation', 'Don'];

        foreach ($categories as $category) {
            Category::create(['title' => $category]);
        }
    }
}
