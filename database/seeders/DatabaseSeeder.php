<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

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
            'password' => '123456',
            'is_completed' => 1,
        ]);
    }
}
