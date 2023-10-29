@php use App\Models\FoodCategory;use App\Models\Restaurant;use App\Models\RestaurantCategory;use App\Models\User; @endphp
<x-app-layout>


    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-pink-500 dark:text-pink-500">
            <thead class="text-xs text-pink-500 uppercase bg-white dark:bg-white dark:text-pink-500">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Image
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Materials
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
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
            @foreach($foods as $food)
                <tr class="bg-white dark:bg-white">


                    <th scope="row" class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                        <a href="{{route('my-restaurant.foods.show',[$restaurant,$food])}}"> {{$food->id}}</a>
                    </th>
                    <td class="px-6 py-4">
                        {{$food->name}}
                    </td>
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/'.$food->image)}}" width="150px" height="150px">
                    </td>
                    <td class="px-6 py-4">
                        {{FoodCategory::query()->find( $food->food_category_id)->name}}
                    </td>
                    <td class="px-6 py-4">
                        {{$food->materials}}
                    </td>
                    <td class="px-6 py-4">
                        {{$food->price}}
                    </td>

                    <td class="px-6 py-4">
                        <form action="{{route('my-restaurant.foods.destroy',[$restaurant,$food])}}" method="post">
                            @csrf
                            @method("DELETE")
                            <x-primary-button
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __(' Delete') }}
                            </x-primary-button>

                        </form>
                    </td>
                    <td class="px-6 py-4">


                        <a href="{{route('my-restaurant.foods.edit',[$restaurant,$food])}}">

                            <x-primary-button
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('edit') }}
                            </x-primary-button>

                        </a>


                    </td>


                </tr>
            @endforeach
            </tbody>
        </table>

        <a href="{{route('my-restaurant.foods.create',$restaurant)}}">

            <x-primary-button
                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add Food') }}
            </x-primary-button>

        </a>

    </div>


</x-app-layout>



