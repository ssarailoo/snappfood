<?php

namespace App\Http\Controllers\Web\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Models\Restaurant\Restaurant;
use App\Models\Schedule\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $this->authorize('viewAny', [Schedule::class, $restaurant]);
        return view('schedule.index', [
            'restaurant' => $restaurant,
            'schedules' => $restaurant->schedules->load('day')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Restaurant $restaurant)
    {
        $this->authorize('create', [Schedule::class, $restaurant]);
        return view('schedule.create', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request, Restaurant $restaurant)
    {
        $this->authorize('create', [Schedule::class, $restaurant]);
        try {
            $schedule = Schedule::query()->create($request->validated());
            $restaurant->schedules()->attach($schedule);
        } catch (QueryException $e) {
            Log::error('Error creating schedule' . $e->getMessage());
        }
        return redirect()->route('my-restaurant.schedules.index', $restaurant)->with('success',
            "A Schedule was made from {$schedule->start_time} to {$schedule->end_time}  on {$schedule->day->name}"
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Schedule $schedule)
    {
        $this->authorize('view', [$schedule, $restaurant]);
        return view('schedule.show', [
            'schedule' => $schedule,
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant, Schedule $schedule)
    {
        $this->authorize('update', [$schedule, $restaurant]);
        return view('schedule.edit', [
            'schedule' => $schedule,
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Restaurant $restaurant, Schedule $schedule)
    {
        $this->authorize('update', [$schedule, $restaurant]);
        try {
            $schedule->update($request->validated());
        } catch (QueryException $e) {
            Log::error('Error Updating schedule' . $e->getMessage());
        }
        return redirect()->route('my-restaurant.schedules.index', $restaurant)->with('success',
            "A Schedule with id  {$schedule->id} Updated from {$schedule->start_time} to {$schedule->end_time}  on {$schedule->day->name}"
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Schedule $schedule)
    {
        $this->authorize('delete', [$schedule, $restaurant]);
        try {
            $schedule->delete();
        } catch (QueryException $e) {
            Log::error('Error Deleting schedule' . $e->getMessage());
        }
        return redirect()->route('my-restaurant.schedules.index', $restaurant)->with('success',
            "A Schedule with id  {$schedule->id} Deleted "
        );
    }
}
