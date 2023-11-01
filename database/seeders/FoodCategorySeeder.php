<?php

namespace Database\Seeders;

use App\Models\Food\FoodCategory;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FoodCategory::query()->insert([
                [
                    'name' => 'Main Dish',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Side Dish',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Kebab',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Fried Chicken',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Pizza',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Dessert',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Appetizer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Drinks',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]
        );
    }
}
