<?php

namespace App\Http\Controllers\Web;

use App\Enums\OrderStauts;
use App\Exports\AllOrdersExport;
use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\FilterCartByCreatedAtRequest;
use App\Http\Requests\Cart\UpdateCartStatusRequest;
use App\Models\Order;
use App\Models\Restaurant\Restaurant;
use App\Notifications\Customer\OrderStatus;
use App\Notifications\Customer\OrderStatusSMS;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Restaurant $restaurant, FilterCartByCreatedAtRequest $request)
    {
        $this->authorize('viewAny', [Order::class, $restaurant]);
        $orders = $restaurant->orders()->with(['restaurant', 'foodsOrder', 'discount'])->where('status', OrderStauts::DELIVERED->value
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
        $orders = Order::query()->where('status', OrderStauts::DELIVERED->value)->with(['restaurant', 'foodsOrder', 'discount'])
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
        $this->authorize('view', [$order, $restaurant]);

        return view('order.show', [
            'order' => $order,
            'restaurant' => $restaurant
        ]);

    }

    public function update(UpdateCartStatusRequest $request, Restaurant $restaurant, Order $order, $newStatus)
    {
        $this->authorize('update', [$order, $newStatus]);
        try {
            $order->update([
                'status' => $newStatus,
            ]);
            Notification::send($order->user, new OrderStatus($order, $newStatus));
            Notification::send($order->user, new OrderStatusSMS($newStatus));
        } catch (QueryException $e) {
            Log::error('Error Updating Order Status');
        }
        $shortHashedId = substr($order->hashed_id, 0, 10);
        return redirect()->route('dashboard')->with('success', "Order with id {$shortHashedId} has been updated to {$newStatus}");
    }

    public function export(Restaurant $restaurant, FilterCartByCreatedAtRequest $request)
    {
        $this->authorize('viewAny', [Order::class, $restaurant]);
        $orders = $restaurant->orders()->where('status', OrderStauts::DELIVERED->value
        )->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
            return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) : $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        })->get();

        return Excel::download(new OrderExport($orders), 'orders.xlsx');
    }

    public function allExport(FilterCartByCreatedAtRequest $request)
    {
        $orders = Order::query()->where('status', OrderStauts::DELIVERED->value)
            ->when(!empty($filter = $request->get('filter_date')), function ($query) use ($filter) {
                return $filter === 'month' ? $query->whereMonth('created_at', Carbon::now()->month) :
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            })->get();
        return Excel::download(new AllOrdersExport($orders), 'allOrders.xlsx');
    }


}
