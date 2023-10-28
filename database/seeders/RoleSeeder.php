<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'restaurant-manager',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        Role::query()->first()->syncPermissions(Permission::all());
        Role::query()->find(2)->syncPermissions([8, 9, 10, 11, 12]);
    }
}
