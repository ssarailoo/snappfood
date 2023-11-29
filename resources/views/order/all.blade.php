@php use App\Enums\CartStatus;use App\Models\Address\Address;use App\Models\Food\FoodParty;use Illuminate\Support\Carbon;use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>

    @if(session('success'))
        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-pink-500 dark:text-pink-500">
                            <thead
                                class="text-xs text-pink-500 uppercase bg-white dark:bg-white dark:text-pink-500">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Restaurant
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Foods
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Customer Payment
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>

                            </tr>
                            {{$carts->withQueryString()->links()}}
                            </thead>
                            <tbody>
                            @foreach($carts as $key=> $cart)
                                <tr class="bg-white dark:bg-white">


                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                                        <a href="{{route('my-restaurant.orders.show',[$cart->restaurant,$cart])}}"> {{$key+1}}</a>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ ucfirst($cart->restaurant->name)}}
                                    </td>
                                    <td class="px-6 py-4" style="white-space: nowrap;">
                                        @php
                                            $cartFoods=    $cart->cartFoods->filter(fn($cartFood)=>$cartFood->in_party===0);
                                            $cartFoodsInParty=    $cart->cartFoods->filter(fn($cartFood)=>$cartFood->in_party===1);
                                        @endphp
                                        Normal:
                                        @foreach($cartFoods as $cartFood)
                                            <p class="text-gray-700 text-base">
                                                {{$cartFood->food->name}} {{$cartFood->price}}
                                                * {{(int)$cartFood->food_count}}
                                                => discount % {{$cartFood->discount_percent}}
                                            </p>
                                        @endforeach
                                        Party:
                                        @foreach($cartFoodsInParty as $cartFood)
                                            <p class="text-gray-700 text-base">
                                                {{$cartFood->food->name}} {{$cartFood->price}}
                                                * {{(int)$cartFood->food_count}}
                                                => discount % {{$cartFood->discount_percent}}
                                            </p>
                                        @endforeach
                                    </td>


                                    <td class="px-6 py-4">
                                        {{$total=$cart->total + $cart->restaurant->cost_of_sending_order}}$
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $total * (100 - ($cart->discount ? $cart->discount->percent : 0)) / 100 }}
                                        $
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $formattedDate = Carbon::parse($cart->created_at)->format('d F Y')}}
                                    </td>

                            @endforeach
                            </tbody>
                        </table>
                        Total Orders: {{$totalOrders}}
                        <br>
                        Total Revenue: {{$totalRevenue}} $
                    </div>

                </div>
                <div class="p-2">
                    <div class="flex justify-between">
                        <form action="">
                            <select name="filter_date">
                                <option value="">All</option>
                                <option value="month">Last Month</option>
                                <option value="week">Last Week</option>
                            </select>
                            <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Filter By Date') }}
                            </x-primary-button>
                        </form>

                                    <form action="{{ route('orders.export', [ 'filter_date' => request()->get('filter_date')]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Export to Excel') }}
                                        </button>

                                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>




