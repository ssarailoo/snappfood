<?php

namespace App\Exports;

use App\Enums\CartStatus;
use App\Models\Cart\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromCollection, WithHeadings
{
    public function __construct(public $orders)
    {

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $counter = 1;
        $data = $this->orders->map(function ($order) use (&$counter) {
            return [
                'Counter' => $counter++,
                'Foods' => $this->getFoodsInfo($order),
                'Total' => $order->total,
                'Customer Payment' => $this->calculateCustomerPayment($order),
                'Date' => $order->created_at->format('d F Y'),

            ];
        });

        return new Collection($data);
    }

    public function headings(): array
    {

        return [
            'Counter',
            'Foods',
            'Total',
            'Customer Payment',
            'Date',

        ];
    }

    private function getFoodsInfo($order)
    {
        return $order->cartFoods->map(function ($cartFood) {
            return "{$cartFood->food->name} ({$cartFood->food_count})";
        })->implode(', ');
    }

    private function calculateCustomerPayment($order)
    {
        if ($order->discount !== null)
            return $order->total * (100 - $order->discount->percent) / 100;
        return $order->total;
    }
}
