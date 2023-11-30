<?php

namespace App\Http\Controllers\Web;

use App\Enums\CartStatus;
use App\Enums\OrderStauts;
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
//        $this->authorize('viewAny', [Cart::class, $restaurant]);
        $orders = $restaurant->orders()->where('status', OrderStauts::DELIVERED->value
        )->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
            return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) : $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        });

        return view('order.index', [
            'orders' => $orders->orderByDesc('created_at')->paginate(10),
            'totalRevenue' => $orders->get()->map(fn($cart) => $cart->total)->sum(),
            'totalOrders' => $orders->get()->count(),
            'restaurant' => $restaurant,

        ]);
    }

    public function allOrders(FilterCartByCreatedAtRequest $request)
    {
       $orders= Order::query()->where('status', OrderStauts::DELIVERED->value)
            ->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
                return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) :
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            });

        return view('order.all', [
            'orders' => $orders->paginate(10),
            'totalOrders' => $orders->get()->count(),
            'totalRevenue' => $orders->get()->map(fn($cart) => $cart->total)->sum()
        ]);
    }

    public function show(Restaurant $restaurant, Order $order)
    {
//        $this->authorize('view', [$cart, $restaurant]);

        return view('order.show', [
            'order' => $order,
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
