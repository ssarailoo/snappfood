<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::query()->create(['name' => 'meat']);
        Material::query()->create(['name' => 'chicken']);
        Material::query()->create(['name' => 'mozzarella cheese']);
        Material::query()->create(['name' => 'bread']);
        Material::query()->create(['name' => 'sausage']);
        Material::query()->create(['name' => 'onion']);
        Material::query()->create(['name' => 'mushroom']);
        Material::query()->create(['name' => 'fish']);
    }
}
