@php use App\Models\Restaurant\Restaurant;use App\Models\Restaurant\RestaurantCategory;use App\Models\User; @endphp
<x-app-layout>

    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-pink-500 dark:text-pink-500">
                <thead class="text-xs text-pink-500 uppercase bg-white dark:bg-white dark:text-pink-500">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Image
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Address
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Telephone
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Bank Account Number
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Restaurant Manager ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Restaurant Manager Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($restaurants as $restaurant)
                    <tr class="bg-white dark:bg-white">


                        <th scope="row"
                            class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                            <a href="{{route('restaurants.edit',$restaurant)}}"> {{$restaurant->id}}</a>
                        </th>
                        <td class="px-6 py-4">
                            <img style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                 src="{{ asset('storage/' . $restaurant->image->url) }}" alt="{{ $restaurant->name }}">
                        </td>
                        <td class="px-6 py-4">
                            {{$restaurant->name}}
                        </td>
                        <td class="px-6 py-4">
                            {{$restaurant->address}}
                        </td>
                        <td class="px-6 py-4">
                            {{$restaurant->telephone}}
                        </td>
                        <td class="px-6 py-4">
                            {{RestaurantCategory::query()->find($restaurant->restaurant_category_id)->name}}
                        </td>

                        <td class="px-6 py-4">
                            {{$restaurant->bank_account_number}}
                        </td>
                        <td class="px-6 py-4">
                            {{$restaurant->user_id}}
                        </td>
                        <td class="px-6 py-4">
                            {{User::query()->find( $restaurant->user_id)->name}}
                        </td>
                        @if($restaurant->trashed())
                            <td class="px-6 py-4">
                                <form action="{{route('restaurants.force',$restaurant)}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <x-primary-button
                                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Force Delete') }}
                                    </x-primary-button>

                                </form>
                            </td>
                            <td class="px-6 py-4">
                                @if(! Restaurant::query()->where('user_id',$restaurant->user_id )->first())

                                    <form action="{{route('restaurants.restore',$restaurant)}}" method="post">
                                        @csrf
                                        @method("PATCH")
                                        <x-primary-button
                                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Restore') }}
                                        </x-primary-button>

                                    </form>
                                @else
                                    #

                                @endif


                            </td>

                        @else
                            <td class="px-6 py-4">
                                #
                            </td>
                            <td class="px-6 py-4">
                                #
                            </td>

                        @endif


                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <form action="">
            <div class="mt-4">

                <x-input-label for="category" class="'block font-medium text-sm text-pink-700" :value="__('Category')"/>
                <select id="category" class="block mt-1 w-full" type="text" name="restaurant_category_id">
                    @foreach(RestaurantCategory::all() as $category)
                        <option value="{{$category->id}}"> {{$category->name}}</option>
                    @endforeach
                </select>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('filter') }}
                </x-primary-button>
            </div>
        </div>
        </form>
    </div>

</x-app-layout>



