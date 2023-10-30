@php use App\Models\FoodCategory;use App\Models\FoodParty; @endphp
<table id="foods-table" class="w-full text-sm text-left text-pink-500 dark:text-pink-500">
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
            Discount
        </th>
        <th scope="col" class="px-6 py-3">
            Status
        </th>


        <th scope="col" class="px-6 py-3">
            Action
        </th>
        <th scope="col" class="px-6 py-3">
            Action
        </th>
        <th scope="col" class="px-6 py-3">
            Food Party
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
                {{$food->discount}}
            </td>
            <td class="px-6 py-4">
                @if(     $food->status==0)
                    Not Available
                @else
                    Available
                @endif
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
            <td class="px-6 py-4">
                @if(!FoodParty::query()->where('food_id',$food->id)->first())
                    <form action="{{route('food-party.store',[$restaurant,$food])}}" method="post">
                        @csrf

                        <div>

                            <x-text-input class="block mt-1 w-full" type="text" name="discount"
                                          :value="old('discount')" placeholder="discount"/>
                            <x-input-error :messages="$errors->get('discount')" class="mt-2"/>
                            <x-text-input class="block mt-1 w-full" type="text" name="quantity"
                                          :value="old('quantity')" placeholder="quantity"/>
                            <x-input-error :messages="$errors->get('discount')" class="mt-2"/>
                            <input type="hidden" name="food_id" value="{{$food->id}}">
                            <x-primary-button
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Add to Food party') }}
                            </x-primary-button>

                        </div>

                    </form>
                @else
                    Allready in Food Party
                @endif
            </td>


        </tr>
    @endforeach
    </tbody>
</table>
