@php use App\Models\Food\FoodCategory;use App\Models\Food\FoodParty; @endphp
<div id="food-cards-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
    @foreach($foods as $food)
        <div class="max-w-sm bg-gray-100 rounded overflow-hidden shadow-lg" id="food-card-{{ $food->id }}">
            <div style="display: flex; justify-content: center; align-items: center; height: 300px;">
                <img style="max-width: 100%; max-height: 100%; object-fit: contain;"
                     src="{{ asset('storage/' . $food->image->url) }}" alt="{{ $food->name }}">
            </div>
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ $food->name }}</div>
                <p class="text-gray-700 text-base">
                    Materials:
                    @foreach($food->materials as $material)
                        <span
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $material->name }}</span>
                    @endforeach
                </p>
            </div>
            <div class="px-6 pt-2 pb-2 grid grid-cols-2 gap-2">
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ FoodCategory::query()->find($food->food_category_id)->name }}</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Price: {{ $food->price }} $</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Discount: {{ $food->discount }} %</span>
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Status: {{ $food->status == 1 ? "Available" : "Not Available" }}</span>
            </div>
            <div class="flex mt-4">
                <form action="{{ route('my-restaurant.foods.destroy', [$restaurant, $food]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 m-2  rounded">
                        {{ __('Delete') }}
                    </x-primary-button>
                </form>
                <a href="{{ route('my-restaurant.foods.edit', [$restaurant, $food]) }}" class="ml-4">
                    <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 m-2  rounded">
                        {{ __('Edit') }}
                    </x-primary-button>
                </a>
            </div>
            <div class="mt-4">
                @if (!FoodParty::query()->where('food_id', $food->id)->first())
                    <form action="{{ route('food-party.store', [$restaurant, $food]) }}" method="post">
                        @csrf
                        <div>
                            <x-text-input class="block mt-1 w-full" type="text" name="discount" :value="old('discount')"
                                          placeholder="Discount"/>
                            <x-input-error :messages="$errors->get('discount')" class="mt-2"/>
                            <x-text-input class="block mt-1 w-full" type="text" name="quantity" :value="old('quantity')"
                                          placeholder="Quantity"/>
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2"/>
                            <input type="hidden" name="food_id" value="{{ $food->id }}">
                            <x-primary-button
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 m-3 rounded">
                                {{ __('Add to Food Party') }}
                            </x-primary-button>
                        </div>
                    </form>
                @else
                    Already in Food Party
                @endif
            </div>
        </div>
    @endforeach
</div>


