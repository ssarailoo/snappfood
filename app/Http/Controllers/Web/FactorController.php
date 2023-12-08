<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class FactorController extends Controller
{
    public function __invoke($hash)
    {

        $order = Order::query()->where('hashed_id', $hash)->first();

        return view('factor.index', [
            'order' => $order
        ]);

    }
}
