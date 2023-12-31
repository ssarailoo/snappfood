<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'name' => 'create-category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'viewAny-categories',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'view-category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'update-category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'delete-category',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'create-banner',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'viewAny-banners',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'view-banner',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'update-banner',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'delete-banner',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'viewAny-restaurants',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'view-restaurant',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'force-delete',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'restore',
                'created_at' => now(),
                'updated_at' => now()
            ],



            [
                'name' => 'create-food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'viewAny-foods',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'view-food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'update-food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'delete-food',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'create-schedule',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'viewAny-schedules',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'view-schedule',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'update-schedule',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'delete-schedule',
                'created_at' => now(),
                'updated_at' => now()
            ],

        ]);
    }
}
