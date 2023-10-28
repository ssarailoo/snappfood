<?php

namespace Database\Seeders;

use App\Models\RestaurantCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                    'name' => 'ایرانی',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'فست-فود',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'کبابی',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'ساندویچی',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]

        );
    }
}
