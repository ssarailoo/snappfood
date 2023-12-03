<?php

use App\Http\Controllers\RestaurantScheduleController;
use App\Http\Controllers\Web\BannerController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DiscountController;
use App\Http\Controllers\Web\FactorController;
use App\Http\Controllers\Web\Food\FoodCategoryController;
use App\Http\Controllers\Web\Food\FoodController;
use App\Http\Controllers\Web\Food\FoodPartyController;
use App\Http\Controllers\Web\MaterialController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\Restaurant\RestaurantCategoryController;
use App\Http\Controllers\Web\Restaurant\RestaurantController;
use App\Http\Controllers\Web\Restaurant\ScheduleController;
use App\Http\Controllers\Web\WelcomeController;
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


Route::get('/', WelcomeController::class);
Route::get('/factor/{hash}', FactorController::class)->name('factor');

// region Authenticated
Route::middleware('auth')->group(function () {

    Route::view('/docs', 'scribe/index')->middleware('role:admin');

    // region Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // endregion


    Route::prefix('/dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

        // region Admin

        //region Restaurant Category
        Route::prefix('/restaurant/categories')->controller(RestaurantCategoryController::class)
            ->name('rest-categories.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::put('/{restaurantCategory}', 'update')->name('update');
                Route::delete('/{restaurantCategory}', 'destroy')->name('destroy');
            });
        // endregion

        // region Food Category
        Route::prefix('/food/categories')->controller(FoodCategoryController::class)
            ->name('food-categories.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::put('/{foodCategory}', 'update')->name('update');
                Route::delete('/{foodCategory}', 'destroy')->name('destroy');
            });
        // endregion
// region Orders
        Route::prefix('/orders')->controller(OrderController::class)->name('orders')->middleware('role:admin')
            ->group(function () {
                Route::get('/all', 'allOrders')->name('.all');
                Route::post('/export/{filterDate?}', 'allExport')->name('.export');
            });
        // endregion
        // region Banner
        Route::resource('banners', BannerController::class);
        // endregion

        //region Comment Admin
        Route::prefix('/comments/')->controller(CommentController::class)->name('comments')->middleware('role:admin')
            ->group(function () {
                Route::get('/review', 'review')->name('.review');
                Route::delete('/{comment}', 'destroy')->name('.destroy');
                Route::get('/new/comments', 'getUpdatedComments')->name('.new');

            });

// endregion

        // region Discount
        Route::resource('/discounts', DiscountController::class)->except(['show']);

        //endregion

        // endregion

        // region Restaurant
        Route::resource('/restaurants', RestaurantController::class);
        Route::prefix('/restaurants')->controller(RestaurantController::class)->name('restaurants.')
            ->group(function () {
                Route::patch('/{restaurant}/location', 'saveLocation')->name('location');
                Route::delete('/{restaurant}/force', 'forceDelete')->name('force')->withTrashed();
                Route::patch('/{restaurant}/restore', 'restore')->name('restore')->withTrashed();
            });
        // endregion

        // region My Restaurant Setting
        Route::prefix('/{restaurant}')->name('my-restaurant.')
            ->group(function () {
                //region Food
                Route::resource('/foods', FoodController::class);
                Route::post('/foods/filter', [FoodController::class, 'filter'])->name('foods.filter');
                // endregion

                // region Schedule
                Route::resource('/schedules', ScheduleController::class);

                //endregion

                // region Comments
                Route::prefix('/comments')->controller(CommentController::class)->name('comments')
                    ->group(function () {
                        Route::get('/', 'index')->name('.index');
                        Route::get('/{comment}', 'show')->name('.show');
                        Route::get('/create/{comment}/', 'create')->name('.create');
                        Route::post('/{comment}', 'store')->name('.store');
                        Route::patch('/{comment}/{newStatus}', 'update')->name('.update');

                    });

                // endregion
                //region Orders
                Route::prefix('/orders')->controller(OrderController::class)->name('orders.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/{order}', 'show')->name('show');
                    Route::patch('/status/{order}/{newStatus}', 'update')->name('update');

                    Route::post('/export/{filterDate?}', 'export')->name('export');
                });

                //endregion
            });


    });
    //endregion

    // region Food Party
    Route::prefix('/party')->controller(FoodPartyController::class)->name('food-party.')
        ->group(function () {
            Route::get('/foods', 'index')->name('index');
            Route::post('/{restaurant}/{food}', 'store')->name('store');
            Route::put('/{restaurant}/{food}/{foodParty}', 'update')->name('update');
            Route::delete('/{restaurant}/{food}/{foodParty}', 'destroy')->name('destroy');
            Route::get('/settings', 'showSetting')->name('showSetting');
            Route::post('/settings', 'setting')->name('setting');

        });
    // endregion

    Route::get('/materials/search', MaterialController::class)->name('materials.suggest');


});

// endregion

require __DIR__ . '/auth.php';
