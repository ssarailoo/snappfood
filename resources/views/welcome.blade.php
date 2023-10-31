
<x-guest-layout>
    <x-slot name="header">
        <!-- You can add a header if needed -->
    </x-slot>

    <div class="text-center">
        <h1 class="text-4xl font-extrabold text-pink-500">Welcome to SnappFood</h1>
        <p class="mt-4 text-lg text-gray-600">Order your favorite food online!</p>
        <a href="{{ route('login') }}" class="mt-8 inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-pink-500 hover:bg-pink-600 focus:outline-none focus:shadow-outline-indigo active:bg-pink-700 transition duration-150 ease-in-out">Get Started</a>
    </div>
</x-guest-layout>
