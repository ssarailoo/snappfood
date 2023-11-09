@php use App\Models\Food\FoodCategory; @endphp
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


                </tr>
                </thead>
                <tbody>

                <tr class="bg-white dark:bg-white">


                    <th scope="row" class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                        {{$food->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$food->name}}
                    </td>
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/'.$food->image->url)}}" width="150px" height="150px">
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
                        @endif
                        Available
                    </td>

                </tr>

                </tbody>
            </table>


        </div>
    </div>

</x-app-layout>



