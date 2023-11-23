
<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('discounts.update',$discount) }}" >
            @method("PUT")
            @csrf

            <!-- Percent -->
            <div>
                <x-input-label for="percent" class="'block font-medium text-sm text-pink-700" :value="__('Percent')"/>
                <x-text-input id="percent" class="block mt-1 w-full" type="text" name="percent" value="{{$discount->percent}}"/>
                <x-input-error :messages="$errors->get('percent')" class="mt-2"/>
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>



