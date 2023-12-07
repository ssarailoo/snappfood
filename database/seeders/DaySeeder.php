<?php

namespace Database\Seeders;

use App\Models\Schedule\Day;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ["Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
        foreach ($days as $day) {
            Day::query()->create([
                'name' => $day
            ]);
        }
    }
}
