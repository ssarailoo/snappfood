<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\FilterCartByStatusRequest;
use App\Models\Cart\Cart;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(FilterCartByStatusRequest $request)
    {
        if (Auth::user()->hasRole('restaurant-manager')) {
            $carts = Auth::user()->restaurant->carts()->where('status', '!=', 'delivered');
            $filter = $request->get('filter_status');
            return view('dashboard', [
                'carts' => $carts->when($filter, function ($query) use ($filter) {
                    return $query->where('status', $filter);
                })->paginate(5),
            ]);
        }
        return view('dashboard');
    }


}
