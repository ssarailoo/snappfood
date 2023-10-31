@php use App\Models\Restaurant;use App\Models\RestaurantCategory;use App\Models\User; @endphp
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

                <tr class="bg-white dark:bg-white">


                    <th scope="row" class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                        {{$restaurant->id}}
                    </th>
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

            </tbody>
        </table>

    </div>
    </div>

</x-app-layout>



