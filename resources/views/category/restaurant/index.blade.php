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
                    Action
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr class="bg-white dark:bg-white">


                    <th scope="row" class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                        {{$category->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$category->name}}
                    </td>
                    <td class="px-6 py-4">
                        <x-edit-r-modal :category="$category"/>
                    </td>


                    <td class="px-6 py-4">
                        <form action="{{route('rest-categories.destroy',$category)}}" method="post">
                            @csrf
                            @method("DELETE")
                            <x-primary-button
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Delete') }}
                            </x-primary-button>

                        </form>
                    </td>

                </tr>
            @endforeach
            <tr class="bg-white dark:bg-white">
                <th scope="row" class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                    #
                </th>
                <td class="px-6 py-4">
                    #
                </td>
                <td class="px-6 py-4">
                    #
                </td>
                <td class="px-6 py-4">

                    <a href="{{route('rest-categories.create')}}">
                        <x-primary-button
                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Create') }}
                        </x-primary-button>
                    </a>

                </td>
            </tr>
            </tbody>
        </table>

    </div>
    </div>

</x-app-layout>


