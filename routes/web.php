<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodCategoryController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantCategoryController;
use App\Http\Controllers\RestaurantController;
use App\Models\Restaurant;
use App\Models\RestaurantCategory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
//        Route::resource('/rest-categories', RestaurantCategoryController::class);
        Route::prefix('/rest-categories')->controller(RestaurantCategoryController::class)
            ->name('rest-categories.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::put('/{restCategory}', 'update')->name('update');
                Route::delete('/{restCategory}', 'destroy')->name('destroy');
            });
//        Route::resource('/food-categories',FoodCategoryController::class);
        Route::prefix('/food-categories')->controller(FoodCategoryController::class)
            ->name('food-categories.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::put('/{foodCategory}', 'update')->name('update');
                Route::delete('/{foodCategory}', 'destroy')->name('destroy');
            });
        Route::resource('/restaurants', RestaurantController::class);
        Route::prefix('/restaurants')->controller(RestaurantController::class)->name('restaurants.')
            ->group(function () {
                Route::delete('/{restaurant}/force', 'forceDelete')->name('force')->withTrashed();
                Route::patch('/{restaurant}/restore', 'restore')->name('restore')->withTrashed();
            });
        Route::prefix('/{restaurant}')->controller(FoodController::class)->name('my-restaurant.')
            ->group(function () {
                Route::get('/foods', 'index')->name('foods.index');
            });


    });

});

require __DIR__ . '/auth.php';
