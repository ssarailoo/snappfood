<?php

namespace Database\Seeders;

use App\Models\Food\Food;
use App\Models\Image;
use App\Models\Material;
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
            'price' => 10,
        ]);
        $firstFood->materials()->sync([1, 3, 4]);
        $firstFood->image()->create([
            'url' => 'images/pizza.jpg',
        ]);
        $secondFood = Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 4,
            'name' => 'fried chicken',
            'price' => 8,
        ]);
        $secondFood->image()->create([
            'url' => 'images/chicken.jpg',
        ]);
        $secondFood->materials()->sync([2]);
        $thirdFood = Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 3,
            'name' => 'donner kebab',
            'price' => 12,
        ]);
        $thirdFood->image()->create([
            'url' => 'images/kebab.jpeg',
        ]);
        $thirdFood->materials()->sync([1, 4]);

        $forthFood= Food::query()->create([
            'restaurant_id' => 1,
            'food_category_id' => 3,
            'name' => 'Joojeh Kabab',
            'price' => 15,
        ]);
        $forthFood->image()->create([
            'url'=>'images/default-food.jpeg'
        ]);
        $thirdFood->materials()->sync([2, 6]);

        $fifthFood= Food::query()->create([
            'restaurant_id' => 1,
            'food_category_id' => 3,
            'name' => 'Kubideh',
            'price' => 15,
        ]);
        $fifthFood->image()->create([
            'url'=>'images/default-food.jpeg'
        ]);
        $fifthFood->materials()->sync([1, 6]);

    }
}
