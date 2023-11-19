<x-guest-layout>

    <div class="mx-auto">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="w-full bg-gray-100 rounded overflow-hidden shadow-lg">
                <div style="display: flex; justify-content: center; align-items: center; height: 300px;">
                    <img style="max-width: 100%; max-height: 100%; object-fit: contain;"
                         src="{{ asset('storage/' . $cart->restaurant->image->url) }}"
                         alt="{{ $cart->restaurant->name }}">
                </div>
                <div  class="px-6 py-4">
                    <p class="text-gray-700 text-base">
                        Status: {{$cart->status}}
                    </p>
                </div>
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{$cart->restaurant->name }}</div>
                    Foods:
                    @foreach($cart->foods->unique('id') as $food)
                        <p class="text-gray-700 text-base">
                            {{$food->name}}           {{$food->price}}
                            * {{(int)$cart->cartFoods->where('food_id', $food->id)->sum('food_count')}}
                        </p>

                    @endforeach
                    <p class="text-gray-700 text-base">
                        Cost of sending Order: {{$cart->restaurant->cost_of_sending_order}}
                    </p>
                    <p class="text-gray-700 text-base">
                        Total: {{$cart->total + $cart->restaurant->cost_of_sending_order}}
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
