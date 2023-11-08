<div x-data="{ isOpen: false }">
    <!-- Edit button -->
    <button @click="isOpen = true" class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
        Edit
    </button>

    <!-- Modal -->
    <div x-show="isOpen" @click.away="isOpen = false" class="absolute inset-y-5/4 left-10 transform -translate-y-1/2 flex items-center justify-center z-50 w-full">
        <div class="bg-white p-4  max-w-2xl" >
            <!-- Edit form -->
            <!-- Include your edit form here, and set the action to your edit route -->
            <form action="{{ route('food-categories.update', $category) }}" method="post">
                @csrf
                @method('PUT')
                <x-input-label for="name" class="'block font-medium text-sm text-pink-700" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"  />
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    Update
                </x-primary-button>
            </form>
        </div>
    </div>
</div>


