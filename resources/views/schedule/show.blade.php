@php @endphp
<x-app-layout>

    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-pink-500 dark:text-pink-500">
                <thead class="text-xs text-pink-500 uppercase bg-white dark:bg-white dark:text-pink-500">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        #
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Day
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Start Time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        End Time
                    </th>

                </tr>
                </thead>
                <tbody>


                <tr class="bg-white dark:bg-white">


                    <th scope="row"
                        class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                        1
                    </th>
                    <td class="px-6 py-4">
                        {{$schedule->day->name}}
                    </td>
                    <td class="px-6 py-4">
                        {{$schedule->start_time}}
                    </td>
                    <td class="px-6 py-4">
                        {{$schedule->end_time}}
                    </td>


                </tr>


                </tbody>
            </table>
            <a href="{{route('my-restaurant.schedules.index',$restaurant)}}">
                <x-primary-button
                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back') }}
                </x-primary-button>
            </a>

        </div>
    </div>

</x-app-layout>



