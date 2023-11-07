<?php

namespace Database\Seeders;

use App\Models\Food\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 5,
           'name'=>'pizza',
            'materials'=>'meat',
            'price'=>100,
            'image'=>'images/sMB2QN5aIz7eSWBeTNcvCpFuBzUbr1f6GNHRtlP4.jpg'
        ]);
        Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 4,
            'name'=>'fried chicken',
            'materials'=>'chicken',
            'price'=>80,
            'image'=>'images/hNmeJyyfDE9bKfCY5wZ9gI4PXCiAw77KJLDSMAYw.jpg'
        ]);
        Food::query()->create([
            'restaurant_id' => 2,
            'food_category_id' => 3,
            'name'=>'donner kebab',
            'materials'=>'meat',
            'price'=>120,
            'image'=>'images/0NAIdqkoiZebKcJGfWslbgdBesyzwr0rqABpWs9u.jpg'
        ]);
    }
}
