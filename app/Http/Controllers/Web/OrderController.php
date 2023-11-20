<?php

namespace App\Http\Controllers\Web;

use App\Enums\CartStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\UpdateCartStatusRequest;
use App\Models\Cart\Cart;
use App\Notifications\Customer\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function update(UpdateCartStatusRequest $request, Cart $cart, $newStatus)
    {
        $this->authorize('update',[$cart, $newStatus]);
        $cart->update([
            'status' => $newStatus,
        ]);
        Notification::send($cart->user, new OrderStatus($cart,$newStatus));
        $shortHashedId=substr($cart->hashed_id,0,10);
        return redirect()->route('dashboard')->with('success', "Order with id {$shortHashedId} has been updated to {$newStatus}");
    }

}
