@php use App\Models\RestaurantCategory;use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
    <form method="POST" action="{{ route('restaurants.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="'block font-medium text-sm text-pink-700" :value="__('Name')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>
        <!-- Address -->
        <div>
            <x-input-label for="address" class="'block font-medium text-sm text-pink-700" :value="__('Address')"/>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="address" :value="old('address')"/>
            <x-input-error :messages="$errors->get('address')" class="mt-2"/>
        </div>
        <!-- telephone -->
        <div>
            <x-input-label for="telephone" class="'block font-medium text-sm text-pink-700" :value="__('Telephone')"/>
            <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone"
                          :value="old('telephone')"/>
            <x-input-error :messages="$errors->get('telephone')" class="mt-2"/>
        </div>
        <!-- Bank Account Number -->
        <div>
            <x-input-label for="bank_account_number" class="'block font-medium text-sm text-pink-700"
                           :value="__('Bank Account Number')"/>
            <x-text-input id="bank_account_number" class="block mt-1 w-full" type="text" name="bank_account_number"
                          :value="old('bank_account_number')"/>
            <x-input-error :messages="$errors->get('bank_account_number')" class="mt-2"/>
        </div>
        <!-- Category -->
        <div>
            <x-input-label for="category" class="'block font-medium text-sm text-pink-700" :value="__('Category')"/>
            <select id="category" class="block mt-1 w-full" type="text" name="restaurant_category_id">
                @foreach(RestaurantCategory::all() as $category)
                    <option value="{{$category->id}}"> {{$category->name}}</option>
                @endforeach
            </select>

            <x-input-error :messages=" $errors->get('restaurant_category_id')" class="mt-2"/>
        </div>
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
    </div>
</x-app-layout>


