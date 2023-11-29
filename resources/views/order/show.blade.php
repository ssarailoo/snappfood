@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <div class="flex justify-center items-center h-screen">
        <div class="max-w-sm bg-gray-100 rounded overflow-hidden shadow-lg">
            <!-- Customer's Name -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:account" data-inline="false"></span>
                <div class="font-bold ml-2">Customer's Name: {{ $cart->user->name }}</div>
            </div>


            <!-- Customer's Phone Number -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:phone" data-inline="false"></span>
                <div class="ml-2">Customer's Phone Number: {{ $cart->user->phone_number }}</div>
            </div>


            <!-- Customer's Address -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:map-marker" data-inline="false"></span>
                <div class="ml-2">Customer's Address: {{ $cart->user->currentAddress->address }}</div>
            </div>


            <!-- Foods -->
            <div class="px-6 py-4">
                <div class="mb-2">Foods:</div>
                @php
                    $cartFoods = $cart->cartFoods->filter(fn($cartFood)=>$cartFood->in_party===0);
                    $cartFoodsInParty = $cart->cartFoods->filter(fn($cartFood)=>$cartFood->in_party===1);
                @endphp
                @foreach($cartFoods as $cartFood)
                    <div class="flex items-center mb-2">
                        <span class="iconify text-xl" data-icon="mdi:food-variant" data-inline="false"></span>
                        <div class="ml-2">
                            {{ $cartFood->food->name }} {{ $cartFood->price }} $
                            * {{ (int)$cartFood->food_count }}
                            @if( $cartFood->discount_percent!=="0.00")
                                => discount % {{ $cartFood->discount_percent }}
                            @endif
                        </div>
                    </div>
                @endforeach


                <!-- Foods in Party -->
                <div class="mb-2">Party:</div>
                @foreach($cartFoodsInParty as $cartFood)
                    <div class="flex items-center mb-2">
                        <span class="iconify text-xl" data-icon="mdi:cake-variant" data-inline="false"></span>
                        <div class="ml-2">
                            {{ $cartFood->food->name }} {{ $cartFood->price }}
                            * {{ (int)$cartFood->food_count }}
                            @if( $cartFood->discount_percent!=="0.00")
                                => discount % {{ $cartFood->discount_percent }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Cost of Sending Order -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:currency-usd-circle" data-inline="false"></span>
                <div class="ml-2">Cost of Sending
                    Order: {{ $costSending = $cart->restaurant->cost_of_sending_order ?? 0 }} $
                </div>
            </div>


            <!-- Total -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:attach-money" data-inline="false"></span>
                <div class="ml-2">Total: {{ $cart->total + $costSending }} $</div>
            </div>


            <!-- SnappFood Discount -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:percent" data-inline="false"></span>
                <div class="ml-2">SnappFood Discount: {{ $cart->discount ?? 0 }} %</div>
            </div>

            <!-- Customer Payment -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:credit-card" data-inline="false"></span>
                <div class="ml-2">Customer Payment: {{ $cart->total * (100 - $cart->discount) / 100 }} $</div>
            </div>

            <!-- Score -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:star" data-inline="false"></span>
                <div class="mb-2 ml-2">Score:</div>
                @if($cart->comments->first() !== null)
                    @for ($i = 2; $i <= 5; $i++)
                        <span class="iconify text-xl"
                              data-icon="mdi:star"
                              style="color: {{ $i > $cart->comments->first()->score ? '#D1D5DB' : '#F59E0B' }}"
                              data-inline="false">
            </span>
                    @endfor
                @else
                    <div class="ml-2">No Score Registered</div>
                @endif
            </div>


            <!-- Comment -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:comment" data-inline="false"></span>
                @if($cart->comments->first() !== null)
                    <div class="ml-2">Comment: {{ $cart->comments->first()->content }}</div>
                @else
                    <div class="ml-2">Comment: No Comment Registered</div>
                @endif
            </div>
        </div>
    </div>
    <div class="flex items-center justify-end mt-4">
        <a href="{{Auth::user()->hasRole('admin')?  route('orders.all'): route('my-restaurant.orders.index',$restaurant)}}">

            <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                {{ __("Back") }}
            </x-primary-button>

        </a>
    </div>
</x-app-layout>
