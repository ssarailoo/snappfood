<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Resources\AddressResource;
use App\Models\Address\Address;
use App\Models\Address\AddressUser;
use App\Models\Banner;
use App\Models\Restaurant\Restaurant;
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
        $user = User::query()->create([
            'name' => 'ali',
            'email' => 'a@yahoo.com',
            'phone_number' => '09112727946',
            'password' => '123456789',

        ]);
        $user2 = User::query()->create([
            'name' => 'hossein',
            'email' => 'h@yahoo.com',
            'phone_number' => '09112740324',
            'password' => '123456789',

        ]);


        $this->call([
            FoodCategorySeeder::class,
            ResturantCategorySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            DaySeeder::class,
        ]);

        $admin->assignRole(Role::query()->first());

        Restaurant::query()->create([
            'name' => 'neshat',
            'address' => 'Tehran , Sattarkhan',
            'telephone' => '12345678',
            'bank_account_number' => '1234567891234',
            'restaurant_category_id' => '1',
            'latitude' => 35.70,
            'longitude' => 51.300,
            'user_id' => $admin->id
        ]);


        Restaurant::query()->create([
            'name' => 'neshat2',
            'address' => 'Tehran , Sattarkhan',
            'telephone' => '12345672',
            'bank_account_number' => '1234567891232',
            'restaurant_category_id' => '2',
            'latitude' => 34.70,
            'longitude' => 50.300,
            'user_id' => $user->id
        ]);
        $this->call([
            FoodSeeder::class
        ]);
        Banner::query()->create([
            'title' => 'Summer Sale',
            'content' => 'Buy 1 Pizza get 2 !',
            'color' => 'violet'
        ]);
        $address = Address::query()->create([
            'title' => 'home',
            'address' => 'tehran sattar khan',
            'latitude' => 33.70,
            'longitude' => 53.300,
        ]);
        AddressUser::query()->create([
            'user_id' => $user2->id,

            'address_id' => $address->id
        ]);
        $user2->update([
            'current_address' => 1
        ]);
        $user->assignRole(Role::query()->find(2));
    }
}
