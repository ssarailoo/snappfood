<?php

namespace App\Exports;


use Illuminate\Support\Collection;
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
        return $order->foodsOrder->map(function ($foodOrder) {
            return "{$foodOrder->food->name} ({$foodOrder->food_count})";
        })->implode(', ');
    }

    private function calculateCustomerPayment($order)
    {
        if ($order->discount !== null)
            return $order->total * (100 - $order->discount->percent) / 100;
        return $order->total;
    }
}
