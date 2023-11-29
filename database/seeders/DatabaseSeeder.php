<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Color;
use App\Http\Resources\AddressResource;
use App\Models\Address\Address;
use App\Models\Address\AddressUser;
use App\Models\Banner;
use App\Models\Image;
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
            'phone_number' => '09112729661',
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
            'phone_number' => '09112729660',
            'password' => '123456789',

        ]);
        $user3 = User::query()->create([
            'name' => 'mohammad',
            'email' => 'm@yahoo.com',
            'phone_number' => '09113744988',
            'password' => '123456789',

        ]);


        $this->call([
            FoodCategorySeeder::class,
            ResturantCategorySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            DaySeeder::class,
        ]);

        $admin->assignRole(Role::findByName('admin'));
        $restaurant = Restaurant::query()->create([
            'name' => 'Shandiz',
            'address' => 'Tehran , Ferdos ',
            'telephone' => '12345673',
            'bank_account_number' => '1234567891231',
            'restaurant_category_id' => '1',
            'latitude' => 35.723184596591,
            'longitude' => 51.318961609131,
            'user_id' => $user3->id
        ]);

        Image::query()->create([
            'url' => 'images/default-restaurant.png',
            'imageable_id' => $restaurant->id,
            'imageable_type' => Restaurant::class
        ]);


        $secondRestaurant = Restaurant::query()->create([
            'name' => 'neshat',
            'address' => 'Tehran , Sattarkhan',
            'telephone' => '12345672',
            'bank_account_number' => '1234567891232',
            'restaurant_category_id' => '2',
            'latitude' => 35.707844934097,
            'longitude' => 51.375545782461,
            'user_id' => $user->id
        ]);
        Image::query()->create([
            'url' => 'images/default-restaurant.png',
            'imageable_id' => $secondRestaurant->id,
            'imageable_type' => Restaurant::class
        ]);
        $this->call([
            MaterialSeeder::class,
            FoodSeeder::class
        ]);
        $banner = Banner::query()->create([
            'title' => 'Summer Sale',
            'content' => 'Buy 1 Pizza get 2 !',
            'color' => Color::PINK->value
        ]);
        $banner->image()->create(['url'=> 'images/banner2.jpeg']);
        $address = Address::query()->create([
            'title' => 'home',
            'address' => 'tehran sattar khan',
            'latitude' => 35.704740840235,
            'longitude' => 51.360176586375,
        ]);
        AddressUser::query()->create([
            'user_id' => $user2->id,

            'address_id' => $address->id
        ]);
        $user2->update([
            'current_address' => 1
        ]);
        $user->assignRole(Role::findByName('restaurant-manager'));
    }
}
