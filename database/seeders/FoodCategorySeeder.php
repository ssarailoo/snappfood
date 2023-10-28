<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                    'name' => 'خورشتی',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'فست-فود',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'کباب',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'سوخاری',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ]
        );
    }
}
