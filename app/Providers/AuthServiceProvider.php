<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use App\Models\Schedule;
use App\Policies\FoodCategoryPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\FoodPolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\SchedulePolicy;
use Database\Seeders\FoodCategorySeeder;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        RestaurantCategory::class => CategoryPolicy::class,
        FoodCategory::class => CategoryPolicy::class,
        Restaurant::class => RestaurantPolicy::class,
        Food::class => FoodPolicy::class,
        Schedule::class => SchedulePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
