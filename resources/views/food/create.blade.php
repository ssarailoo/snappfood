@php use App\Models\Food\FoodCategory; @endphp
<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('my-restaurant.foods.store',$restaurant) }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" class="'block font-medium text-sm text-pink-700" :value="__('Name')"/>
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"/>
                <x-input-error :messages="$errors->get('name')" class="mt-2"/>
            </div>
            <!-- Materials -->
            <div>
                <x-input-label for="materials" class="'block font-medium text-sm text-pink-700"
                               :value="__('Materials')"/>
                <x-text-input id="materials" class="block mt-1 w-full" type="text" name="materials"
                              :value="old('materials')"/>
                <x-input-error :messages="$errors->get('materials')" class="mt-2"/>
            </div>
            <!--Price  -->
            <div>
                <x-input-label for="price" class="'block font-medium text-sm text-pink-700" :value="__('Price')"/>
                <x-text-input id="price" class="block mt-1 w-full" type="text" name="price"
                              :value="old('price')"/>
                <x-input-error :messages="$errors->get('price')" class="mt-2"/>
            </div>


            <!-- Category -->
            <div>
                <x-input-label for="category" class="'block font-medium text-sm text-pink-700" :value="__('Category')"/>
                <select id="category" class="block mt-1 w-full" type="text" name="food_category_id">
                    @foreach(FoodCategory::all() as $category)
                        <option value="{{$category->id}}"> {{$category->name}}</option>
                    @endforeach
                </select>

                <x-input-error :messages=" $errors->get('food_category_id')" class="mt-2"/>
            </div>
            <x-input-label for="image" class="'block font-medium text-sm text-pink-700" :value="__('Image')"/>
            <input type="file" id="image" name="url">
            <x-input-error :messages=" $errors->get('url')" class="mt-2"/>
            <input type="hidden" name="restaurant_id" value="{{$restaurant->id}}">

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
        <div class="bg-white p-6">
</x-app-layout>


