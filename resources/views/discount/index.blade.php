@php use App\Models\Food\FoodCategory;use App\Models\Food\FoodParty; @endphp
<x-app-layout>
    @if(session('success'))
        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif


        <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-pink-500 dark:text-pink-500">
                    <thead class="text-xs text-pink-500 uppercase bg-white dark:bg-white dark:text-pink-500">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                           Code
                        </th>
                        <th scope="col" class="px-6 py-3">
                        Percent
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Expired At
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
                    @foreach($discounts as $discount)
                        <tr class="bg-white dark:bg-white">


                            <th scope="row"
                                class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                                 {{$discount->id}}
                            </th>

                            <td class="px-6 py-4">
                                {{$discount->code}}
                            </td>
                            <td class="px-6 py-4">
                                {{$discount->percent}}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::now()->diffInDays($discount->expired_at) }} days
                            </td>

                                <td class="px-6 py-4">
                                    <form action="{{route('discounts.destroy',$discount)}}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <x-primary-button
                                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                            {{ __('Delete') }}
                                        </x-primary-button>
                                    </form>
                                </td>
                            <td class="px-6 py-4">
                                <a href="{{route('discounts.edit',$discount)}}">
                                    <x-primary-button
                                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                        {{ __('Edit') }}
                                    </x-primary-button>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <a href="{{route('discounts.create')}}">
                    <x-primary-button
                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Create') }}
                    </x-primary-button>
                </a>
            </div>
        </div>
</x-app-layout>


