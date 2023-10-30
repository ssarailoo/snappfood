<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\FoodCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin = User::query()->create([
            'name' => 'saeed',
            'email' => 's@yahoo.com',
            'phone_number' => '09112729660',
            'password' => '123456789',

        ]);
         User::query()->create([
            'name' => 'ali',
            'email' => 'a@yahoo.com',
            'phone_number' => '09112727946',
            'password' => '123456789',

        ]);
        $this->call([
            FoodCategorySeeder::class,
            ResturantCategorySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class
        ]);

        $admin->assignRole(Role::query()->first());
    }
}
