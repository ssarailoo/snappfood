<x-app-layout>

    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <h1>500</h1>
        <h3>An Unexpected Error Occurred</h3>
    </div>
    <a href="{{$route}}">
        <x-primary-button
            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
            {{ __("Back") }}
        </x-primary-button>
    </a>
</x-app-layout>
