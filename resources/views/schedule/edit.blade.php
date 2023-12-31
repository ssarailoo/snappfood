@php use App\Models\Schedule\Day; @endphp
<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <form method="POST" action="{{ route('my-restaurant.schedules.update',[$restaurant,$schedule]) }}">
            @csrf
            @method('PUT')
            <!-- Day -->
            <div>
                <x-input-label for="day" class="'block font-medium text-sm text-pink-700" :value="__('Day')"/>
                <select id="day" name="day_id">
                    @foreach(Day::all() as $day)
                        <option
                                value="{{$day->id}} @if($schedule->day->id == $day->id) selected  @endif ">{{$day->name}}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('day')" class="mt-2"/>
            </div>
            <!-- Start Time -->
            <div>
                <x-input-label for="start_time" class="'block font-medium text-sm text-pink-700"
                               :value="__('Start Time')"/>
                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time"
                              value="{{$schedule->start_time}}"/>
                <x-input-error :messages="$errors->get('start_time')" class="mt-2"/>
            </div>
            <!-- End Time -->
            <div>
                <x-input-label for="end_time" class="'block font-medium text-sm text-pink-700"
                               :value="__('End Time')"/>
                <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time"
                              value="{{$schedule->end_time}}"/>
                <x-input-error :messages="$errors->get('end_time')" class="mt-2"/>
            </div>


            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>


