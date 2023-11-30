@php use App\Enums\CommentStatus;use App\Models\Food\Food; @endphp
<x-app-layout>
    @if(session('success'))
        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
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
                                    Author
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Author Phone Number
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
                                    Action
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
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
                        </table>
                    </div>
                </div>
                <div class="p-2">
                    <form action="" class="flex gap-4 items-center">
                        <div class="flex items-center">
                            <x-input-label class="'block mr-2 font-medium text-white"
                                           :value="__('Status')"/>
                            <select name="status">
                                <option value="">all</option>
                                @php
                                   $statuses= CommentStatus::getValues();
                                   unset($statuses[0]);
                                   unset($statuses[1]);
                                @endphp
                                @foreach( $statuses as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center">
                            <x-input-label class="'block mr-2 font-medium  text-white"
                                           :value="__('Food')"/>
                            <select name="food">
                                <option value="">all</option>
                                @foreach(Food::all() as $food)
                                    <option value="{{$food->id}}">{{$food->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center">
                            <button
                                type="submit"
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Filter') }}
                            </button>
                        </div>

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
                    data-dismiss="modal" onclick="submitAcceptForm()">
                    {{ __('Yes, Accept') }}
                </x-primary-button>
            </div>

        </div>
    </div>
</div>
<!-- Deny Modal HTML -->
<div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden" id="denyConfirmationModal">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <!-- Modal content -->
        <div class="modal-content py-4 text-left px-6">

            <div class="modal-header">
                <h5 class="modal-title font-bold text-lg text-gray-700">Confirmation</h5>
            </div>

            <div class="modal-body">
                Are you sure you want to Delete the comment?
            </div>


            <div class="modal-footer mt-4">
                <x-primary-button
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                    data-dismiss="modal" onclick="closeDenyConfirmationModal()">
                    {{ __('Close') }}
                </x-primary-button>

                <x-primary-button
                    type="button"
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                    onclick="submitDenyForm()">
                    {{ __('Yes, Delete') }}
                </x-primary-button>
            </div>

        </div>
    </div>
</div>

<!-- Description Modal HTML -->
<div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden" id="descriptionModal">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <!-- Modal content -->
        <div class="modal-content py-4 text-left px-6">

            <div class="modal-header">
                <h5 class="modal-title font-bold text-lg text-gray-700">Add Description</h5>
            </div>

            <div class="modal-body">
                <div>
                    <x-input-label class="'block font-medium text-sm text-pink-700"
                                   :value="__('Description')"/>
                    <x-text-input id="description-input" class="block mt-1 w-full" type="text"
                                  :value="old('description')"/>

                </div>
            </div>

            <div class="modal-footer mt-4">
                <x-primary-button
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                    data-dismiss="modal" onclick="closeDescriptionModal()">
                    {{ __('Close') }}
                </x-primary-button>

                <x-primary-button
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                    data-dismiss="modal" onclick="submitForm()">
                    {{ __('Add') }}
                </x-primary-button>
            </div>

        </div>
    </div>
</div>

<script>
    function showDenyConfirmationModal() {
        document.getElementById('denyConfirmationModal').classList.remove('hidden');
    }

    function closeDenyConfirmationModal() {
        document.getElementById('denyConfirmationModal').classList.add('hidden');
    }

    function submitDenyForm() {
        document.getElementById('denyForm').submit();
    }
</script>


<script>
    function showConfirmationModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function closeConfirmationModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    function submitAcceptForm() {

        document.forms["acceptForm"].submit();


    }
</script>

<script>
    function showDescriptionModal() {
        document.getElementById('descriptionModal').classList.remove('hidden');
    }

    function closeDescriptionModal() {
        document.getElementById('descriptionModal').classList.add('hidden');
    }

    function submitForm() {
        var description = document.getElementById('description-input').value;
        document.getElementById('hiddenDescription').value = description;
        document.forms["reconsiderForm"].submit();
    }
</script>
