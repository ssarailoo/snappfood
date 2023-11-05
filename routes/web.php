<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Food\FoodCategoryController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Food\FoodPartyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Restaurant\RestaurantCategoryController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\Restaurant\ScheduleController;
use App\Http\Controllers\RestaurantScheduleController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Knuckles\Scribe\ScribeServiceProvider;

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

Route::get('/', WelcomeController::class);

Route::middleware('auth')->group(function () {
    Route::view('/docs', 'scribe/index')->middleware('role:admin');
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
                Route::patch('/{restaurant}/location', 'saveLocation')->name('location');
                Route::delete('/{restaurant}/force', 'forceDelete')->name('force')->withTrashed();
                Route::patch('/{restaurant}/restore', 'restore')->name('restore')->withTrashed();
            });
        Route::prefix('/{restaurant}')->name('my-restaurant.')
            ->group(function () {
                Route::resource('/foods', FoodController::class);
                Route::post('/foods/filter', [FoodController::class, 'filter'])->name('foods.filter');
                Route::resource('/schedules', ScheduleController::class);
            });


        Route::prefix('food-party')->controller(FoodPartyController::class)->name('food-party.')
            ->group(function () {
                Route::get('/foods', 'index')->name('index');
                Route::post('/{restaurant}/{food}', 'store')->name('store');
                Route::put('/{restaurant}/{food}/{foodParty}', 'update')->name('update');
                Route::delete('/{restaurant}/{food}{foodParty}', 'destroy')->name('destroy');
                Route::get('/settings', 'showSetting')->name('showSetting');
                Route::post('/settings', 'setting')->name('setting');
            });
        Route::resource('banners', BannerController::class);

    });

});

require __DIR__ . '/auth.php';
