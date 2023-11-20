@php use App\Enums\CommentStatus;use App\Models\Comment;use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
        <div class="mb-4">
            Author: {{$cart->user->name}}
        </div>
        <div class="mb-4">
            Phone Number: {{$cart->user->phone_number}}
        </div>
        <div class="mb-4">
            Foods:
            @foreach($cart->foods->unique('id') as $food)
                <p class="text-gray-700 text-base">
                    {{$food->name}} * {{(int)$cart->cartFoods->where('food_id', $food->id)->sum('food_count')}}
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

        <form
            action="{{route('my-restaurant.comments.store',['restaurant'=>Auth::user()->restaurant,'comment'=>$comment])}}"
            method="post">
            @csrf

            <!-- Comment -->
            @php
                $reply=Comment::query()->where('parent_id',$comment->id)->first()
            @endphp
            @if ($reply==! null)
                <div>
                    <x-input-label for="comment" class="'block font-medium text-sm text-pink-700"
                                   :value="__('Comment')"/>
                    <x-text-input id="comment" class="block mt-1 w-full" type="text" name="content"
                                  value="{{$reply->content}}"
                    />
                    <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                </div>
            @else
                <div>
                    <x-input-label for="comment" class="'block font-medium text-sm text-pink-700"
                                   :value="__('Comment')"/>
                    <x-text-input id="comment" class="block mt-1 w-full" type="text" name="content"
                                  :value="old('content')"/>


                    <x-input-error :messages="$errors->get('content')" class="mt-2"/>
                </div>
            @endif
            <input type="hidden" name="parent_id" value="{{$comment->id}}">
            <input type="hidden" name="cart_id" value="{{$cart->id}}">
            <input type="hidden" name="status" value="{{CommentStatus::Accepted}}">
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                    {{ __("Reply") }}
                    </x-primary-button>
                </div>
        </form>
    </div>
</x-app-layout>
