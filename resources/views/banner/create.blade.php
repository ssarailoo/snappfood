@php use App\Enums\Color; @endphp
<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('banners.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Title-->
            <div>
                <x-input-label for="title" class="'block font-medium text-sm text-pink-700" :value="__('Title')"/>
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"/>
                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
            </div>
            <!-- Content-->
            <div>
                <x-input-label for="content" class="'block font-medium text-sm text-pink-700" :value="__('Content')"/>
                <x-text-input id="content" class="block mt-1 w-full" type="text" name="content"
                              :value="old('content')"/>
                <x-input-error :messages="$errors->get('content')" class="mt-2"/>
            </div>
            <!-- Color-->
            <div>
                <x-input-label for="color" class="'block font-medium text-sm text-pink-700" :value="__('Color')"/>
                <select name="color" id="color">
                    @foreach(Color::getValues() as $color)
                        <option value="{{$color}}">{{$color}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('color')" class="mt-2"/>
            </div>
            <x-input-label for="image" class="'block font-medium text-sm text-pink-700" :value="__('Image')"/>
            <input type="file" id="image" name="url">
            <x-input-error :messages=" $errors->get('url')" class="mt-2"/>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>


