@php use App\Models\FoodCategory;use App\Models\RestaurantCategory;use Illuminate\Support\Facades\Auth; @endphp
<x-guest-layout>
    <form method="POST" action="{{ route('my-restaurant.foods.update',[$restaurant,$food]) }}" enctype="multipart/form-data">
        @csrf
@method("PUT")
        <!-- Name -->
        <div>
            <x-input-label for="name" class="'block font-medium text-sm text-pink-700" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{$food->name}}"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <!-- Materials -->
        <div>
            <x-input-label for="materials" class="'block font-medium text-sm text-pink-700" :value="__('Materials')"/>
            <x-text-input id="materials" class="block mt-1 w-full" type="text" name="materials"
                          value="{{$food->materials}}"/>
            <x-input-error :messages="$errors->get('materials')" class="mt-2"/>
        </div>
        <!--Price  -->
        <div>
            <x-input-label for="price" class="'block font-medium text-sm text-pink-700" :value="__('Price')"/>
            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price"
                          value="{{$food->price}}"/>
            <x-input-error :messages="$errors->get('price')" class="mt-2"/>
        </div>
        <!--Discount  -->
        <div>
            <x-input-label for="discount" class="'block font-medium text-sm text-pink-700" :value="__('Discount')"/>
            <x-text-input id="discount" class="block mt-1 w-full" type="text" name="discount"
                          value="{{$food->discount}}"/>
            <x-input-error :messages="$errors->get('discount')" class="mt-2"/>
        </div>
        <!--Status  -->
        <div>
            <x-input-label for="status" class="'block font-medium text-sm text-pink-700" :value="__('Status')"/>
            <select id="category" class="block mt-1 w-full" name="food_category_id">

                <option value="0" @if($food->status == 0) selected @endif>Not Available</option>
                <option value="1" @if($food->status == 1) selected @endif>Available</option>

            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2"/>
        </div>


        <!-- Category -->
        <div>
            <x-input-label for="category" class="block font-medium text-sm text-pink-700" :value="__('Category')"/>
            <select id="category" class="block mt-1 w-full" name="food_category_id">
                @foreach(FoodCategory::all() as $category)
                    <option value="{{$category->id}}"
                            @if($food->food_category_id == $category->id) selected @endif>{{$category->name}}</option>
                @endforeach
            </select>

            <x-input-error :messages=" $errors->get('food_category_id')" class="mt-2"/>
        </div>
        <x-input-label for="image" class="'block font-medium text-sm text-pink-700" :value="__('Image')"/>
        <input type="file" id="image" name="image">
        <x-input-error :messages=" $errors->get('image')" class="mt-2"/>
        <img src="{{ asset('storage/'.$food->image)}}" alt="">

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Update') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>

