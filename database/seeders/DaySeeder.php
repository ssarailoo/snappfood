<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ["saturday", "sunday", "monday", "tuesday", "wednesday", "thursday", "friday"];
        foreach ($days as $day) {
            Day::query()->create([
                'name' => $day
            ]);
        }
    }
}
