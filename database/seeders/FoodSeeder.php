<?php

namespace Database\Seeders;

use App\Models\Food\Food;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstFood = Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 5,
            'name' => 'pizza',
            'materials' => 'meat',
            'price' => 100,
        ]);
        $firstFood->image()->create([
            'url' => 'images/pizza.jpg',
        ]);
        $secondFood = Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 4,
            'name' => 'fried chicken',
            'materials' => 'chicken',
            'price' => 80,
        ]);
        $secondFood->image()->create([
            'url' => 'images/chicken.jpg',
        ]);
        $thirdFood = Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 3,
            'name' => 'donner kebab',
            'materials' => 'meat',
            'price' => 120,
        ]);
        $thirdFood->image()->create([
            'url' => 'images/kebab.jpeg',
        ]);
    }
}
