@php use App\Enums\Status;use App\Models\Address\Address;use Illuminate\Support\Facades\Auth; @endphp
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
            @if(Auth::user()->restaurant==!null)
                <div>
                    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-pink-500 dark:text-pink-500" >
                                <thead
                                    class="text-xs text-pink-500 uppercase bg-white dark:bg-white dark:text-pink-500">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Customer's Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Customer's Address
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Customer's Phone Number
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Foods
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($carts as $key=> $cart)
                                    <tr class="bg-white dark:bg-white">


                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                                            <a href=""> {{ substr($cart->hashed_id, 0, 10)}}</a>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{$cart->user->name}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{Address::query()->find( $cart->user->current_address)->address}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$cart->user->phone_number}}
                                        </td>
                                        <td class="px-6 py-4"  style="white-space: nowrap;">
                                            @foreach($cart->foods->unique('id') as $food)
                                                <p class="text-gray-700 text-base">
                                                    {{$food->name}} {{$food->price}} * {{(int)$cart->cartFoods->where('food_id', $food->id)->sum('food_count')}}
                                                </p>
                                            @endforeach
                                        </td>


                                        <td class="px-6 py-4">
                                            {{$cart->total + Auth::user()->restaurant->cost_of_sending_order}}$
                                        </td>

                                        <td class="px-6 py-4">
                                            {{$cart->status}}
                                        </td>
                                        @if($cart->status === Status::CHECKING->value)
                                        <td class="px-6 py-4">
                                                <form action="{{route('orders.status.update',['cart' => $cart, 'newStatus' => Status::CANCELED->value])}}" method="post">
                                                    @method("PATCH")
                                                    @csrf
                                                <div class="flex items-center justify-end mt-4">
                                                    <x-primary-button
                                                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                        {{ __('Cancel') }}
                                                    </x-primary-button>
                                                </div>
                                                </form>

                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{route('orders.status.update',['cart' => $cart, 'newStatus' => Status::PREPARING->value])}}" method="post">
                                                @method("PATCH")
                                                @csrf
                                            <div class="flex items-center justify-end mt-4">
                                                <x-primary-button
                                                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                    {{ __('Preparing') }}
                                                </x-primary-button>

                                            </div>
                                            </form>
                                        </td>
                                    @endif
                                        @if($cart->status === Status::PREPARING->value)
                                        <td class="px-6 py-4">

                                            <form action="{{route('orders.status.update',['cart' => $cart, 'newStatus' => Status::SHIPPING->value])}}" method="post">
                                                    @method("PATCH")
                                                    @csrf

                                                    <div class="flex items-center justify-end mt-4">
                                                        <x-primary-button
                                                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('Shipping') }}
                                                        </x-primary-button>
                                                    </div>
                                                </form>

                                        </td>
                                        <td class="px-6 py-4">
                                           #
                                        </td>
                                        @endif
                                        @if($cart->status === Status::SHIPPING->value)
                                            <td class="px-6 py-4">
                                                <form action="{{route('orders.status.update',['cart' => $cart, 'newStatus' => Status::DELIVERED->value])}}" method="post">
                                                @method("PATCH")
                                                @csrf

                                                <div class="flex items-center justify-end mt-4">
                                                    <x-primary-button
                                                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                        {{ __('Delivered') }}
                                                    </x-primary-button>
                                                </div>
                                            </form>

                                            </td>
                                            <td class="px-6 py-4">
                                                #
                                            </td>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
</x-app-layout>
