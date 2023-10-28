<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\FoodCategory;
use App\Models\RestaurantCategory;
use App\Policies\FoodCategoryPolicy;
use App\Policies\CategoryPolicy;
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
        FoodCategory::class => CategoryPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
