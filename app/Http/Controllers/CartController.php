<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Resources\Cart\CartCollection;
use App\Http\Resources\Cart\CartResource;
use App\Models\Cart\Cart;
use App\Models\Cart\CartFood;
use App\Models\Food\Food;
use App\Services\CartPayService;
use App\Services\CartTotalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return response(new CartCollection(Auth::user()->carts), 200);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request, CartTotalService $cartTotalService)
    {
        $cart = Cart::query()->create([
            'user_id' => Auth::user()->id,
            'restaurant_id' => Food::query()->find($request->food_id)->restaurant->id,
        ]);
        CartFood::query()->create([
            'food_id' => $request->food_id,
            'cart_id' => $cart->id,
            'food_count' => $request->food_count
        ]);

        $cartTotalService->updateTotal($request, $cart);

        return response([
            'msg' => 'Cart Created successfully',
            'cart_id' => $cart->id
        ], 201);
    }

    /**
     * Display the specified resource.
     * @apiResource App\Http\Resources\Cart\CartResource
     * @apiResourceModel App\Models\Cart\Cart
     */
    public function show(Cart $cart)
    {
        $this->authorize('isCartBelongingToUser', $cart);
        return response(new CartResource($cart), 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart, CartTotalService $cartTotalService)
    {
        $this->authorize('isCartBelongingToUser', $cart);
        CartFood::query()->create([
            'food_id' => $request->food_id,
            'cart_id' => $cart->id,
            'food_count' => $request->food_count
        ]);
        $cartTotalService->updateTotal($request, $cart);
        return response([
            'msg' => 'your cart updated successfully',

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $this->authorize('isCartBelongingToUser', $cart);
        $cart->delete();
        return response()->json([
            'message' => 'Your cart was deleted successfully.'
        ], 204);

    }

    public function pay(Cart $cart, CartPayService $cartService)
    {
        $this->authorize('isCartBelongingToUser', $cart);
        $response = $cartService->payCart($cart, Auth::user());

        if (isset($response['msg'])) {
            return response($response, 400);
        }

        return response($response, 200);
    }
}
