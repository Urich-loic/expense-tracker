<?php

namespace Database\Seeders;

use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;
class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = Category::all();

        foreach (range(1, 20) as $i) {
            Expense::create([
                'title' => $faker->sentence(3),
                'user_id' => 1,
                'description'=>'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nemo culpa aperiam, beatae accusantium laborum quo? Ipsum quisquam hic iste voluptas atque minima quod a nesciunt rem.' , // Assuming the first user is the one to whom expenses belong
                'amount' => $faker->randomFloat(2, 5, 200),
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
