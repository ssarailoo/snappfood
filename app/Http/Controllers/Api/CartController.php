<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CheckDiscountCodeRequest;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart\Cart;
use App\Notifications\Customer\OrderRegistration;
use App\Notifications\Customer\OrderRegistrationSMS;
use App\Notifications\Restaurant\OrderRegistration as RestaurantOrderRegistration;
use App\Services\Cart\CartDestroyService;
use App\Services\Cart\CartPayService;
use App\Services\Cart\CartStoreService;
use App\Services\Cart\CartTotalService;
use App\Services\Cart\CartUpdateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

/**
 * @group Cart
 *
 */
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * @apiResourceCollection App\Http\Resources\Cart\CartCollection
     * @apiResourceModel App\Models\Cart\Cart
     * @response {
     *      "data": [
     *          {
     *              "id": 1,
     *              "restaurant": {
     *                  "title": "Restaurant Name"
     *              },
     *              "foods": [
     *                  {
     *                      "food_id": 2,
     *                      "food_count": 3
     *                  }
     *              ],
     *              "created_at": "2023-11-01T12:34:56Z",
     *              "updated_at": "2023-11-01T12:34:56Z"
     *          }
     *      ]
     *  }
     */
    public function index(Request $request)
    {

        return response()->json(new CartCollection(Auth::user()->carts->filter(fn($cart) => $cart->is_paid === 0)), 200);

    }


    /**
     * *
     *  Store a newly created resource in storage.
     *
     * @response 201 {
     *      "msg": "Cart Created successfully",
     *      "cart_id": 1
     *  }
     */
    public function store(StoreCartRequest $request, CartStoreService $cartStoreService, CartTotalService $cartTotalService)
    {
        $this->authorize('create', Cart::class);
        $response = $cartStoreService->storeCart();
        $cartTotalService->updateTotal($response['cart']);
        return $response['data']['message'] === "Cart Created successfully" ?
            response()->json($response['data']
                , 201) : response()->json($response['data']
            );
    }

    /**
     * Display the specified resource.
     * @apiResource App\Http\Resources\Cart\CartResource
     * @apiResourceModel App\Models\Cart\Cart
     * @response App\Http\Resources\Cart\CartResource
     *
     * @param Cart $cart
     */
    public function show(Cart $cart)
    {
        $this->authorize('view', $cart);
        return response()->json(new CartResource($cart), 200);
    }


    /**
     * Update the specified resource in storage.
     * @response 200 {
     *      "msg": "Your cart updated successfully"
     *  }
     */
    public function update(UpdateCartRequest $request, Cart $cart, CartUpdateService $cartUpdateService, CartTotalService $cartTotalService)
    {
        $this->authorize('update', $cart);
        $response = $cartUpdateService->updateService($cart);
        $cartTotalService->updateTotal($cart);
        return response()->json([
            'data' => $response
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @response 204
     */
    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart);
        $cart->delete();
        return response()->json([
            'data' => ['success' => true, 'msg' => 'Your cart was deleted successfully.']
        ]);

    }

    /**
     * Pay for the specified cart.
     *
     * @response 200 {
     *     "msg": "Your cart has been paid successfully"
     * }
     *
     * @response 400 {
     *     "msg": "Bad Request: First choose your current address"
     * }
     *
     * @response 400 {
     *     "msg": "Bad Request: Already paid"
     * }
     *
     *
     */
    public function pay(CheckDiscountCodeRequest $request, Cart $cart, CartPayService $cartPayService)
    {
        $this->authorize('pay', $cart);
        $response = $cartPayService->payCart($cart, Auth::user());
        Notification::send($cart->user, new OrderRegistration($cart));
        Notification::send($cart->user, new OrderRegistrationSMS());
        Notification::send($cart->restaurant->user, new RestaurantOrderRegistration($cart));
        $cart->delete();
        return response()->json([
            'data' => $response
        ], 201);

    }
}
