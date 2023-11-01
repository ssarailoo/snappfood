@php use App\Models\FoodCategory;use App\Models\FoodParty;use App\Models\Restaurant;use App\Models\RestaurantCategory;use App\Models\User; @endphp
<x-app-layout>
    @if(session('success'))
        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    {{ $foods->appends(['sort_by' => $sortMethod])->links() }}
    <div class="sm:p-8  bg-white shadow sm:rounded-lg p-6">
        <div id="food-cards-container" >
            <div class="grid  grid-cols-1  sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                @foreach($foods as $food)
                    <div class="max-w-sm bg-gray-100 rounded overflow-hidden shadow-lg" id="food-card-{{ $food->id }}">
                        <div style="display: flex; justify-content: center; align-items: center; height: 300px;">
                            <img style="max-width: 100%; max-height: 100%; object-fit: contain;" src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}">
                        </div>
                        <div class="px-6 py-4">
                            <div class="font-bold text-xl mb-2">{{ $food->name }}</div>
                            <p class="text-gray-700 text-base">
                                Materials: {{ $food->materials }}
                            </p>
                        </div>
                        <div class="px-6 pt-2 pb-2 grid grid-cols-2 gap-2">
                        <span
                            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ FoodCategory::query()->find($food->food_category_id)->name }}</span>
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Price: {{ $food->price }}</span>
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Discount: {{ $food->discount }}</span>
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Status: {{ $food->status == 1 ? "Available" : "Not Available" }}</span>
                        </div>

                        <!-- Food Action Buttons -->
                        <div class="flex mt-4">
                            <form action="{{ route('my-restaurant.foods.destroy', [$restaurant, $food]) }}"
                                  method="post">
                                @csrf
                                @method("DELETE")
                                <x-primary-button
                                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 m-2  rounded">
                                    {{ __('Delete') }}
                                </x-primary-button>
                            </form>
                            <a href="{{ route('my-restaurant.foods.edit', [$restaurant, $food]) }}" class="ml-4">
                                <x-primary-button
                                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 m-2  rounded">
                                    {{ __('Edit') }}
                                </x-primary-button>
                            </a>
                        </div>
                        <!-- Add to Food Party -->
                        <div class="mt-4">
                            @if(!FoodParty::query()->where('food_id', $food->id)->first())
                                <form action="{{ route('food-party.store', [$restaurant, $food]) }}" method="post">
                                    @csrf
                                    <div>
                                        <x-text-input class="block mt-1 w-full" type="text" name="discount"
                                                      :value="old('discount')" placeholder="Discount"/>
                                        <x-input-error :messages="$errors->get('discount')" class="mt-2"/>
                                        <x-text-input class="block mt-1 w-full" type="text" name="quantity"
                                                      :value="old('quantity')" placeholder="Quantity"/>
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
        </div>
        <div class="flex flex-wrap items-center justify-between">
            <a href="{{ route('my-restaurant.foods.create', $restaurant) }}" class="m-2">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Add Food') }}
                </x-primary-button>
            </a>
            <!-- Filter Form by category -->
            <form id="filterForm" onsubmit="filterFoods(); return false;" class="flex items-center">
                @csrf
                <x-input-label for="food_category_id" class="mr-2">Filter by Category:</x-input-label>
                <select name="food_category_id" id="food_category_id" class="mr-2">
                    <option value="">All Categories</option>
                    @foreach (FoodCategory::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" id="restaurant" value="{{ $restaurant->id }}">
                <x-primary-button id="filterButton"
                                  class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Apply Filter') }}
                </x-primary-button>
            </form>

            <!-- Sort Form -->
            <form id="sortForm" action="{{ route('my-restaurant.foods.index', $restaurant) }}" method="get">
                <x-input-label for="sort_by" class="mr-2">Sort By:</x-input-label>
                <select name="sort_by" id="sort_by" class="mr-2">
                    <option value="name_asc">Name (Ascending)</option>
                    <option value="name_desc">Name (Descending)</option>
                    <option value="price_asc">Price (Ascending)</option>
                    <option value="price_desc">Price (Descending)</option>
                </select>
                <button type="submit" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Apply Filter') }}
                </button>
            </form>
        </div>
    </div>


</x-app-layout>

<script>
    function filterFoods() {
        console.log('filterFoods function called');
        let foodCategoryId = $('#food_category_id').val();
        let restaurantId = $('#restaurant').val();

        $.ajax({
            url: '{{ route('my-restaurant.foods.filter',$restaurant) }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                food_category_id: foodCategoryId,
                restaurant_id: restaurantId
            },
            success: function (data) {

                $('#food-cards-container').html(data);
            }
        });
    }
</script>

{{--<script>--}}
{{--    var filterRoute = "{{ route('food.filter') }}";--}}
{{--</script>--}}
{{--<script src="{{ mix('js/app.js') }}"></script>--}}




