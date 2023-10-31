<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
    <form method="POST" action="{{ route('rest-categories.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="'block font-medium text-sm text-pink-700" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"  />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
        </div >
</x-app-layout>

