<?php

namespace Database\Seeders;

use App\Models\Restaurant\RestaurantCategory;
use Illuminate\Database\Seeder;

class ResturantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestaurantCategory::query()->insert([
                [
                    'name' => 'Restaurant',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Fast Food',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Cafe',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Fast Causal',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Food Truck',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Buffet',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Italian Cuisine',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Bistro',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]

        );
    }
}
