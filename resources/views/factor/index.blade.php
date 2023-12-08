<x-guest-layout>

    <div class="mx-auto">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="w-full bg-gray-100 rounded overflow-hidden shadow-lg">
                <div style="display: flex; justify-content: center; align-items: center; height: 300px;">
                    <img style="max-width: 100%; max-height: 100%; object-fit: contain;"
                         src="{{ asset('storage/' . $order->restaurant->image->url) }}"
                         alt="{{ $order->restaurant->name }}">
                </div>
                <div  class="px-6 py-4">
                    <p class="text-gray-700 text-base">
                        Status: {{$order->status}}
                    </p>
                </div>
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{$order->restaurant->name }}</div>
                    Foods:
                    @foreach($order->foodsOrder as $foodOrder)
                        <p class="text-gray-700 text-base">
                            {{$foodOrder->food->name}}           {{$foodOrder->food->price}}
                            * {{(int)$foodOrder->food_count}}
                        </p>

                    @endforeach
                    <p class="text-gray-700 text-base">
                        Cost of sending Order: {{$order->restaurant->cost_of_sending_order}} $
                    </p>
                    <p class="text-gray-700 text-base">
                        Total: {{$order->total + $order->restaurant->cost_of_sending_order}} $
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
