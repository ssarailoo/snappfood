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
        Image::query()->create([
            'url' => 'images/pizza.jpg',
            'imageable_id' => $firstFood->id,
            'imageable_type' => Food::class
        ]);
        $secondFood = Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 4,
            'name' => 'fried chicken',
            'materials' => 'chicken',
            'price' => 80,
        ]);
        Image::query()->create([
            'url' => 'images/chicken.jpg',
            'imageable_id' => $secondFood->id,
            'imageable_type' => Food::class
        ]);
        $thirdFood = Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 3,
            'name' => 'donner kebab',
            'materials' => 'meat',
            'price' => 120,
        ]);
        Image::query()->create([
            'url' => 'images/kebab.jpeg',
            'imageable_id' => $thirdFood->id,
            'imageable_type' => Food::class
        ]);
    }
}
