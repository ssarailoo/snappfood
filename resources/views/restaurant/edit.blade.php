@php use App\Models\Restaurant\RestaurantCategory; @endphp
<x-app-layout>
    @if(session('success'))
        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('restaurants.update',$restaurant) }}">
            @csrf
            @method("PUT")

            <!-- Name -->
            <div>
                <x-input-label for="name" class="'block font-medium text-sm text-pink-700" :value="__('Name')"/>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                              value="{{$restaurant->name}}"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <!-- Address -->
            <div>
                <x-input-label for="address" class="'block font-medium text-sm text-pink-700" :value="__('Address')"/>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="address"
                              value="{{$restaurant->address}}"/>
                <x-input-error :messages="$errors->get('address')" class="mt-2"/>
            </div>
            <!-- telephone -->
            <div>
                <x-input-label for="telephone" class="'block font-medium text-sm text-pink-700"
                               :value="__('Telephone')"/>
                <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone"
                              value="{{$restaurant->telephone}}"/>
                <x-input-error :messages="$errors->get('telephone')" class="mt-2"/>
            </div>
            <!-- Bank Account Number -->
            <div>
                <x-input-label for="bank_account_number" class="'block font-medium text-sm text-pink-700"
                               :value="__('Bank Account Number')"/>
                <x-text-input id="bank_account_number" class="block mt-1 w-full" type="text" name="bank_account_number"
                              value="{{$restaurant->bank_account_number}}"/>
                <x-input-error :messages="$errors->get('bank_account_number')" class="mt-2"/>
            </div>
            <!-- Cost Of Sending Order -->
            <div>
                <x-input-label for="cost_of_sending_order" class="'block font-medium text-sm text-pink-700"
                               :value="__('Cost Of Sending Order')"/>
                <x-text-input id="cost_of_sending_order" class="block mt-1 w-full" type="text"
                              name="cost_of_sending_order"
                              value="{{$restaurant->cost_of_sending_order ?? 0}} $"/>
                <x-input-error :messages="$errors->get('cost_of_sending_order')" class="mt-2"/>
            </div>
            <!-- Location -->
            <div id="map" style="height: 400px;"></div>
            <x-input-label class="'block font-medium text-sm text-pink-700"
                           :value="__('Choose Your Location ')"/>
            <button type="button" id="saveLocationBtn"
                    class="bg-pink-500 hover-bg-pink-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Save Location') }}
            </button>


            <!-- Category -->
            <div>
                <x-input-label for="category" class="'block font-medium text-sm text-pink-700" :value="__('Category')"/>
                <select id="category" class="block mt-1 w-full" type="text" name="restaurant_category_id">
                    @foreach(RestaurantCategory::all() as $category)
                        <option value="{{$category->id}}"
                                @if($restaurant->restaurantCategory == $category) selected @endif > {{$category->name}}</option>
                    @endforeach
                </select>

                <x-input-error :messages=" $errors->get('restaurant_category_id')" class="mt-2"/>
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
        <form action="{{route('restaurants.destroy',$restaurant)}}" method="post">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Delete') }}
                </x-primary-button>
            </div>
        </form>


        <a href="{{route('my-restaurant.foods.index',$restaurant)}}">
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Food Section') }}
                </x-primary-button>
            </div>
        </a>
        <a href="{{route('my-restaurant.schedules.index',$restaurant)}}">
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Schedule Section') }}
                </x-primary-button>
            </div>
        </a>
        <div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var defaultLatitude = {{ $latitude }};
            var defaultLongitude = {{ $longitude }};
            var map;
            var marker;

            if (defaultLatitude !== 0 && defaultLongitude !== 0) {
                map = L.map("map").setView([defaultLatitude, defaultLongitude], 13);
                marker = L.marker([defaultLatitude, defaultLongitude]).addTo(map);
            } else {
                // Set a default location if latitude and longitude are null
                var map = L.map("map").setView([35.6895, 51.3906], 13); // Tehran, Iran
            }
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
            }).addTo(map);

            map.on('click', function (e) {
                if (marker) {
                    map.removeLayer(marker); // Remove the previous marker
                }

                // Set marker to the selected location
                marker = L.marker(e.latlng, {draggable: true, autoPan: true}).addTo(map);
                marker.setOpacity(1);

                // e.latlng contains the picked latitude and longitude
                latitude = e.latlng.lat;
                longitude = e.latlng.lng;
            });

            var saveLocationBtn = document.getElementById('saveLocationBtn');
            console.log("Save Location button:", saveLocationBtn);

            saveLocationBtn.addEventListener('click', function () {
                // Set the latitude and longitude in hidden input fields

                // Send an AJAX request to save the location
                $.ajax({
                    type: 'PATCH',
                    url: '{{ route("restaurants.location",$restaurant) }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: function (data) {
                        // Handle the success response here, e.g., show a success message
                        console.log('Location saved successfully');
                    },
                    error: function (data) {
                        // Handle any errors here, e.g., show an error message
                        console.error('Error saving location');
                    }
                });
            });
        });
    </script>


</x-app-layout>
