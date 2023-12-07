<?php

namespace Database\Seeders;

use App\Models\Restaurant\Restaurant;
use App\Models\Schedule\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurant = Restaurant::query()->where('name', 'neshat')->first();
        $dayIds = [1, 2, 3, 4, 5, 6, 7];
        foreach ($dayIds as $dayId) {
            $schedule = Schedule::query()->create([
                'day_id' => $dayId,
                "start_time" => "08:00",
                "end_time" => "23:00"
            ]);
            $restaurant->schedules()->attach($schedule);
        }

    }
}
