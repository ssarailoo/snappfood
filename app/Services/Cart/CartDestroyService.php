<?php

namespace App\Services\Cart;

use App\Models\Cart\Cart;

class CartDestroyService
{
    public function destroyCart(Cart $cart)
    {
        return $cart->is_paid === 1 ? ['msg' => "Bad Request:this cart has been paid you can't delete it."] :
            ['success' => true, 'msg' => 'Your cart was deleted successfully.'];

    }
}
