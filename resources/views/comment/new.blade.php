@php use App\Enums\CommentStatus; @endphp
<tbody id="comment-container" >
@foreach($comments as $key=> $comment)
    <tr class="bg-white dark:bg-white">
        <th scope="row"
            class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
            <a href=""> {{ $comment->id}}</a>
        </th>
        <td class="px-6 py-4">
            {{$comment->order->user->name}}
        </td>

        <td class="px-6 py-4">
            {{$comment->order->user->phone_number}}
        </td>
        <td class="px-6 py-4" style="white-space: nowrap;">
            @foreach($comment->order->foodsOrder as $foodOrder)
                <p class="text-gray-700 text-base">
                    {{$foodOrder->food->name}}
                    * {{(int)$foodOrder->food_count}}
                </p>
            @endforeach
        </td>
        <td class="px-6 py-4 grid grid-flow-col auto-cols-max items-center gap-1">

            @php
                $score = $comment->score;
            @endphp
            @for ($i = 1; $i <= 5; $i++)
                <span class="iconify" data-icon="bi:star-fill" data-inline="false"
                      style=" color: @if ($i > $score) #D1D5DB; @else #F59E0B; @endif;"></span>
            @endfor
        </td>

        <td class="px-6 py-4">
            {{$comment->content}}
        </td>
        <td class="px-6 py-4">
            {{$comment->status}}
        </td>
        @if($comment->status===CommentStatus::REVIEWING_BY_ADMIN->value)
            <td class="px-6 py-4">
                <form id="reconsiderForm"
                      action="{{route('my-restaurant.comments.update' ,['restaurant'=>$comment->order->restaurant,'comment' =>$comment, 'newStatus' => CommentStatus::RECONSIDERING_BY_CUSTOMER->value])}}"
                      method="post">
                    @method("PATCH")
                    @csrf

                    <input type="hidden" name="description" id="hiddenDescription" value="">
                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                    <div class="flex items-center justify-end mt-4">
                        <button
                            type="button"
                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                            onclick="showDescriptionModal()">

                            {{ __('Reconsider') }}
                        </button>
                    </div>

                </form>
            </td>
            <td class="px-6 py-4">
                <form id="acceptForm"
                      action="{{route('my-restaurant.comments.update',['restaurant'=>$comment->order->restaurant,'comment' =>$comment, 'newStatus' => CommentStatus::Accepted->value])}}"
                      method="post">
                    @method("PATCH")
                    @csrf

                    <div class="flex items-center justify-end mt-4">
                        <button
                            type="button"
                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                            onclick="showConfirmationModal()">
                            {{ __('Accept') }}
                        </button>
                    </div>
                </form>
            </td>
        @elseif($comment->status===CommentStatus::RECONSIDERING_BY_CUSTOMER->value and $comment->reconsidered===1)
            <td class="px-6 py-4">
                <form id="denyForm"
                      action="{{route('comments.destroy' ,$comment)}}"
                      method="post">
                    @method("DELETE")
                    @csrf

                    <div class="flex items-center justify-end mt-4">
                        <button
                            type="button"
                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                            onclick="showDenyConfirmationModal()">
                            {{ __('Delete') }}
                        </button>
                    </div>
                </form>
            </td>
            <td class="px-6 py-4">
                <form id="acceptForm"
                      action="{{route('my-restaurant.comments.update',['restaurant'=>$comment->order->restaurant,'comment' =>$comment, 'newStatus' => CommentStatus::Accepted->value])}}"
                      method="post">
                    @method("PATCH")
                    @csrf

                    <div class="flex items-center justify-end mt-4">
                        <button
                            type="button"
                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                            onclick="showConfirmationModal()">
                            {{ __('Accept') }}
                        </button>
                    </div>
                </form>
            </td>
    @endif
@endforeach
</tbody>
