<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Address;
use App\Models\Banner;
use App\Models\Food\Food;
use App\Models\Food\FoodCategory;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantCategory;
use App\Models\Schedule\Schedule;
use App\Policies\AddressPolicy;
use App\Policies\BannerPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\FoodCategoryPolicy;
use App\Policies\FoodPolicy;
use App\Policies\RestaurantPolicy;
use App\Policies\SchedulePolicy;
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
        Schedule::class => SchedulePolicy::class,
        Banner::class => BannerPolicy::class,
        Address::class=>AddressPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
