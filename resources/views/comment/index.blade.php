@php use App\Enums\CommentStatus;use App\Models\Address\Address;use App\Models\Comment;use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>
    @if(session('success'))
        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div>
                    <div class="sm:p-8 bg-white shadow sm:rounded-lg p-6">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-pink-500 dark:text-pink-500">
                                <thead
                                    class="text-xs text-pink-500 uppercase bg-white dark:bg-white dark:text-pink-500">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        ID
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Customer's Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Foods
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Score
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Comment
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Reply
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($comments as $key=> $comment)
                                    @if ($comment)
                                    <tr class="bg-white dark:bg-white">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                                            <a href="{{route('my-restaurant.comments.show',['restaurant'=>$restaurant,'comment'=>$comment])}}"> {{$key+1 }}</a>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{$comment->order->user->name}}
                                        </td>

                                        <td class="px-6 py-4" style="white-space: nowrap;">
                                            @foreach($comment->order->foodsOrder as $cartFood)
                                                <p class="text-gray-700 text-base">
                                                    {{$cartFood->food->name}}
                                                    * {{(int)$cartFood->food_count}}
                                                </p>
                                            @endforeach
                                        </td>
                                        @if($comment===null)
                                            <td class="px-6 py-4">
                                                -
                                            </td>
                                            <td class="px-6 py-4">
                                                -
                                            </td>
                                            <td class="px-6 py-4">
                                                -
                                            </td>
                                            <td class="px-6 py-4">#</td>
                                            <td class="px-6 py-4">#</td>
                                        @else
                                            <td class="px-6 py-4 grid grid-flow-col auto-cols-max items-center gap-1">
                                                <br>
                                                <br>
                                                <br>
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
                                            <td class="px-6 py-4">
                                                {{Comment::query()->where('parent_id',$comment->id)->first()->content ?? "-"}}
                                            </td>
                                            @if($comment->status===CommentStatus::PENDING->value)


                                                <td class="px-6 py-4">
                                                    <form
                                                        action="{{route('my-restaurant.comments.update',['restaurant'=>$restaurant,'comment' =>$comment, 'newStatus' => CommentStatus::REVIEWING_BY_ADMIN->value])}}"
                                                        method="post">
                                                        @method("PATCH")
                                                        @csrf

                                                        <div class="flex items-center justify-end mt-4">
                                                            <x-primary-button
                                                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                                {{ __('Review') }}
                                                            </x-primary-button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <form id="acceptForm"
                                                          action="{{route('my-restaurant.comments.update',['restaurant'=>$restaurant,'comment' =>$comment, 'newStatus' => CommentStatus::Accepted->value])}}"
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
                                            @elseif($comment->status===CommentStatus::Accepted->value)
                                                <td class="px-6 py-4">
                                                    <a href="{{route('my-restaurant.comments.create',[$restaurant,$comment])}}">

                                                        <div class="flex items-center justify-end mt-4">
                                                            <x-primary-button
                                                                type="button"
                                                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                                {{ __('Reply') }}
                                                            </x-primary-button>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4">
                                                    #
                                                </td>

                                    @endif
                                    @endif
                                    @endif

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="p-2">
                        <form action="">
                            <select name="status">
                                <option value="">all</option>
                                @foreach(CommentStatus::getValues() as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>

                            <button
                                type="submit"
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Filter By Status') }}
                            </button>

                        </form>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal HTML -->
<div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden" id="confirmationModal">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <!-- Modal content -->
        <div class="modal-content py-4 text-left px-6">

            <div class="modal-header">
                <h5 class="modal-title font-bold text-lg text-gray-700">Confirmation</h5>
            </div>

            <div class="modal-body">
                Are you sure you want to Accept the comment?
            </div>

            <div class="modal-footer mt-4">
                <x-primary-button
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                    data-dismiss="modal" onclick="closeConfirmationModal()">
                    {{ __('Close') }}
                </x-primary-button>

                <x-primary-button
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                    data-dismiss="modal" onclick="submitForm()">
                    {{ __('Yes, Accept') }}
                </x-primary-button>
            </div>

        </div>
    </div>
</div>


<script>
    function showConfirmationModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function closeConfirmationModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    function submitForm() {

        document.forms["acceptForm"].submit();


    }
</script>
