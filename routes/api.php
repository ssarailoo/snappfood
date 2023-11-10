<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\RestaurantController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout',[AuthController::class,'logout']);
    Route::prefix('/addresses')->controller(AddressController::class)->name('addresses.')
        ->group(function () {
            Route::get('/', 'index')->name('.index');
            Route::get('/{address}', 'show')->name('.show');
            Route::post('/', 'store')->name('.store');
            Route::put('/{address}/', 'update')->name('.update');
            Route::delete('/{address}/', 'destroy')->name('.destroy');
            Route::patch('/current/{address}', 'updateUserAddress')->name('update.user');
        });
    Route::prefix('/restaurants')->controller(RestaurantController::class)->name('restaurants.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{restaurant}', 'show')->name('show');
        });
    Route::get('/restaurants/{restaurant}/foods', [FoodController::class, 'index'])->name('foods.index');
    Route::prefix('/carts')->controller(CartController::class)->name('carts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{cart}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::patch('/{cart}', 'update')->name('update');
        Route::delete('/{cart}', 'destroy')->name('destroy');
        Route::patch('/{cart}/pay', 'pay')->name('pay');
    });
    Route::prefix('/comments')->controller(CommentController::class)->name('comments.')
        ->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get('/','index')->name('index');
        });
});
