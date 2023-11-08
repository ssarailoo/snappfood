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

     Role::create([
         'name'=>'admin'
     ]);
     Role::create([
         'name'=>'restaurant-manager'
     ]);
            Role::findByName('admin')->syncPermissions([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]);

            Role::findByName('restaurant-manager')->syncPermissions([15, 16, 17, 18, 19, 20, 21, 22, 23, 24]);

    }
}
