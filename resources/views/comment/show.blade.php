@php use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <div class="mb-4">
            Author: {{$comment->cart->user->name}}
        </div>
        <div class="mb-4">
            Phone Number: {{$comment->cart->user->phone_number}}
        </div>
        <div class="mb-4">
            Foods:
            @foreach($comment->cart->cartFoods as $cartFood)
                <p class="text-gray-700 text-base">
                    {{$cartFood->food->name}} * {{(int)$cartFood->food_count}}
                </p>
            @endforeach
        </div>
        <div class="mb-4 flex">
            Score:
            @for ($i = 1; $i <= 5; $i++)
                <span class="iconify" data-icon="bi:star-fill" data-inline="false"
                      style=" color: @if ($i > $comment->score) #D1D5DB; @else #F59E0B; @endif;"></span>
            @endfor
        </div>
        <div class="mb-4">
            Comment: {{$comment->content}}
        </div>
        <a href="{{route('my-restaurant.comments.index',$restaurant)}}">
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __("Back") }}
                </x-primary-button>
            </div>
        </a>
    </div>

</x-app-layout>
