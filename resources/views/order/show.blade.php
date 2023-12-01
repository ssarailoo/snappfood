@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <div class="flex justify-center items-center h-screen">
        <div class="max-w-sm bg-gray-100 rounded overflow-hidden shadow-lg">
            <!-- Customer's Name -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:account" data-inline="false"></span>
                <div class="font-bold ml-2">Customer's Name: {{ $order->user->name }}</div>
            </div>


            <!-- Customer's Phone Number -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:phone" data-inline="false"></span>
                <div class="ml-2">Customer's Phone Number: {{ $order->user->phone_number }}</div>
            </div>


            <!-- Customer's Address -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:map-marker" data-inline="false"></span>
                <div class="ml-2">Customer's Address: {{ $order->user->currentAddress->address }}</div>
            </div>


            <!-- Foods -->
            <div class="px-6 py-4">
                <div class="mb-2">Foods:</div>
                @php
                    $orderFoods = $order->foodsOrder->filter(fn($orderFood)=>$orderFood->in_party===0);
                    $orderFoodsInParty = $order->foodsOrder->filter(fn($orderFood)=>$orderFood->in_party===1);
                @endphp
                @foreach($orderFoods as $orderFood)
                    <div class="flex items-center mb-2">
                        <span class="iconify text-xl" data-icon="mdi:food-variant" data-inline="false"></span>
                        <div class="ml-2">
                            {{ $orderFood->food->name }} {{ $orderFood->price }} $
                            * {{ (int)$orderFood->food_count }}
                            @if( $orderFood->discount_percent!=="0.00")
                                => discount % {{ $orderFood->discount_percent }}
                            @endif
                        </div>
                    </div>
                @endforeach


                <!-- Foods in Party -->
                <div class="mb-2">Party:</div>
                @foreach($orderFoodsInParty as $orderFood)
                    <div class="flex items-center mb-2">
                        <span class="iconify text-xl" data-icon="mdi:cake-variant" data-inline="false"></span>
                        <div class="ml-2">
                            {{ $orderFood->food->name }} {{ $orderFood->price }}
                            * {{ (int)$orderFood->food_count }}
                            @if( $orderFood->discount_percent!=="0.00")
                                => discount % {{ $orderFood->discount_percent }}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Cost of Sending Order -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:currency-usd-circle" data-inline="false"></span>
                <div class="ml-2">Cost of Sending
                    Order: {{ $costSending = $order->restaurant->cost_of_sending_order ?? 0 }} $
                </div>
            </div>


            <!-- Total -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:attach-money" data-inline="false"></span>
                <div class="ml-2">Total: {{ $order->total + $costSending }} $</div>
            </div>


            <!-- SnappFood Discount -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:percent" data-inline="false"></span>
                <div class="ml-2">SnappFood Discount: {{ $order->discount->percent ?? 0 }} %</div>
            </div>

            <!-- Customer Payment -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:credit-card" data-inline="false"></span>
                @if($order->discount!==null)
                <div class="ml-2">Customer Payment: {{ $order->total * (100 - $order->discount->percent) / 100 }} $</div>
                @else  <div class="ml-2">Customer Payment:  {{ $order->total + $costSending }} $</div>
                @endif
            </div>

            <!-- Score -->
            <div class="flex items-center px-6 py-4">
                <span class="iconify text-xl" data-icon="mdi:star" data-inline="false"></span>
                <div class="mb-2 ml-2">Score:</div>
                @if($order->comments->first() !== null)
                    @for ($i = 2; $i <= 5; $i++)
                        <span class="iconify text-xl"
                              data-icon="mdi:star"
                              style="color: {{ $i > $order->comments->first()->score ? '#D1D5DB' : '#F59E0B' }}"
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
                @if($order->comments->first() !== null)
                    <div class="ml-2">Comment: {{ $order->comments->first()->content }}</div>
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
