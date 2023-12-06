<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\FilterOrderByStatusRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(FilterOrderByStatusRequest $request)
    {
        if (Auth::user()->hasRole('restaurant-manager')) {
            $orders = Auth::user()->restaurant->orders()->with(['user','user.currentAddress','foodsOrder'])
                ->where('status', '!=', 'delivered');
            $filter = $request->get('filter_status');
            return view('dashboard', [
                'orders' => $orders->when(!empty($filter), function ($query) use ($filter) {
                    return $query->where('status', $filter);
                })->paginate(5),
                'restaurant'=>Auth::user()->restaurant
            ]);
        }
        return view('dashboard');
    }


}
