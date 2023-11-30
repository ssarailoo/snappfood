<?php

namespace App\Http\Controllers\Web;

use App\Enums\CartStatus;
use App\Exports\AllOrdersExport;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\FilterCartByCreatedAtRequest;
use App\Http\Requests\Cart\UpdateCartStatusRequest;
use App\Models\Cart\Cart;
use App\Models\Order;
use App\Models\Restaurant\Restaurant;
use App\Notifications\Customer\OrderStatus;
use App\Notifications\Customer\OrderStatusSMS;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Restaurant $restaurant, FilterCartByCreatedAtRequest $request)
    {
        $this->authorize('viewAny', [Cart::class, $restaurant]);
        $carts = $restaurant->carts()->where('status', CartStatus::DELIVERED->value
        )->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
            return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) : $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        });

        return view('order.index', [
            'carts' => $carts->orderByDesc('created_at')->paginate(10),
            'totalRevenue' => $carts->get()->map(fn($cart) => $cart->total)->sum(),
            'totalOrders' => $carts->get()->count(),
            'restaurant' => $restaurant,

        ]);
    }

    public function allOrders(FilterCartByCreatedAtRequest $request)
    {
       $carts= Cart::query()->where('status', CartStatus::DELIVERED->value)
            ->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
                return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) :
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            });

        return view('order.all', [
            'carts' => $carts->paginate(10),
            'totalOrders' => $carts->get()->count(),
            'totalRevenue' => $carts->get()->map(fn($cart) => $cart->total)->sum()
        ]);
    }

    public function show(Restaurant $restaurant, Cart $cart)
    {
        $this->authorize('view', [$cart, $restaurant]);

        return view('order.show', [
            'cart' => $cart,
            'restaurant' => $restaurant
        ]);

    }

    public function update(UpdateCartStatusRequest $request,Restaurant $restaurant, Order $order, $newStatus)
    {
//        $this->authorize('update', [$cart, $newStatus]);
        $order->update([
            'status' => $newStatus,
        ]);
        Notification::send($order->user, new OrderStatus($order, $newStatus));
        Notification::send($order->user, new OrderStatusSMS($newStatus));
        $shortHashedId = substr($order->hashed_id, 0, 10);
        return redirect()->route('dashboard')->with('success', "Order with id {$shortHashedId} has been updated to {$newStatus}");
    }

    public function export(Restaurant $restaurant, FilterCartByCreatedAtRequest $request)
    {
        $this->authorize('viewAny', [Cart::class, $restaurant]);
        $carts = $restaurant->carts()->where('status', CartStatus::DELIVERED->value
        )->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
            return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) : $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })->get();

        return Excel::download(new OrderExport($carts), 'orders.xlsx');
    }

    public function allExport(FilterCartByCreatedAtRequest $request)
    {
        $carts= Cart::query()->where('status', CartStatus::DELIVERED->value)
            ->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
                return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) :
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            })->get();
        return Excel::download(new AllOrdersExport($carts), 'allOrders.xlsx');
    }


}
