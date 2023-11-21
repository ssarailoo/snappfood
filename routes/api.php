<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\RestaurantController;

use App\Http\Controllers\Api\UserController;
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
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('personal/update', UserController::class)->name('information.update');
    //region Address
    Route::apiResource('/addresses', AddressController::class);
    Route::patch('/addresses/current/{address}', [AddressController::class, 'updateUserAddress'])->name('addresses.current');
    //endregion

    //region Restaurant
    Route::prefix('/restaurants')->controller(RestaurantController::class)->name('restaurants.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{restaurant}', 'show')->name('show');
        });
    Route::get('/restaurants/{restaurant}/foods', [FoodController::class, 'index'])->name('foods.index');
    Route::get('/food/party', [FoodController::class, 'foodParty'])->name('food.party');
    //endregion

    // region Cart
    Route::apiResource('/carts', CartController::class);
    Route::patch('/carts/{cart}/pay', [CartController::class, 'pay'])->name('carts.pay');
    //endregion

    //region Comment
    Route::prefix('/comments')->controller(CommentController::class)->name('comments.')
        ->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get('/', 'index')->name('index');
        });
    //endregion
});


