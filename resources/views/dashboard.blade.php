@php use App\Enums\CartStatus;use App\Models\Address\Address;use App\Models\Food\FoodParty;use Illuminate\Support\Facades\Auth; @endphp
<x-app-layout>

    @if(session('success'))
        <div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 mb-4" role="alert">
            <p class="font-bold">Success!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Auth::user()->restaurant==!null)
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
                                        Customer's Address
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Customer's Phone Number
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Foods
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Customer Payment
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
                                {{$carts->withQueryString()->links()}}
                                </thead>
                                <tbody>
                                @foreach($carts as $key=> $cart)
                                    <tr class="bg-white dark:bg-white">


                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-pink-500 whitespace-nowrap dark:text-pink-500">
                                            <a href=""> {{ substr($cart->hashed_id, 0, 10)}}</a>
                                        </th>
                                        <td class="px-6 py-4">
                                            {{$cart->user->name}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{Address::query()->find( $cart->user->current_address)->address}}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$cart->user->phone_number}}
                                        </td>
                                        <td class="px-6 py-4" style="white-space: nowrap;">
                                            @php
                                                $cartFoods=    $cart->cartFoods->filter(fn($cartFood)=>$cartFood->in_party===0);
                                                $cartFoodsInParty=    $cart->cartFoods->filter(fn($cartFood)=>$cartFood->in_party===1);
                                            @endphp
                                            Normal:
                                            @foreach($cartFoods as $cartFood)
                                                <p class="text-gray-700 text-base">
                                                    {{$cartFood->food->name}} {{$cartFood->price}}
                                                    * {{(int)$cartFood->food_count}}
                                                    => discount % {{$cartFood->discount_percent}}
                                                </p>
                                            @endforeach
                                            Party:
                                            @foreach($cartFoodsInParty as $cartFood)
                                                <p class="text-gray-700 text-base">
                                                    {{$cartFood->food->name}} {{$cartFood->price}}
                                                    * {{(int)$cartFood->food_count}}
                                                    => discount % {{$cartFood->discount_percent}}
                                                </p>
                                            @endforeach
                                        </td>


                                        <td class="px-6 py-4">
                                            {{$total=$cart->total + Auth::user()->restaurant->cost_of_sending_order}}$
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $total * (100 - ($cart->discount ? $cart->discount->percent : 0)) / 100 }}
                                            $
                                        </td>

                                        <td class="px-6 py-4">
                                            {{$cart->status}}
                                        </td>
                                        @if($cart->status === CartStatus::CHECKING->value)
                                            <td class="px-6 py-4">
                                                <form id="cancelForm"
                                                      action="{{ route('orders.status.update', ['cart' => $cart, 'newStatus' => CartStatus::CANCELED->value]) }}"
                                                      method="post">
                                                    @method("PATCH")
                                                    @csrf
                                                    <div class="flex items-center justify-end mt-4">
                                                        <button
                                                            type="button"
                                                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded"
                                                            onclick="showConfirmationModal()">
                                                            {{ __('Cancel') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4">
                                                <form
                                                    action="{{route('orders.status.update',['cart' => $cart, 'newStatus' => CartStatus::PREPARING->value])}}"
                                                    method="post">
                                                    @method("PATCH")
                                                    @csrf
                                                    <div class="flex items-center justify-end mt-4">
                                                        <x-primary-button
                                                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('Preparing') }}
                                                        </x-primary-button>

                                                    </div>
                                                </form>
                                            </td>
                                        @endif
                                        @if($cart->status === CartStatus::PREPARING->value)
                                            <td class="px-6 py-4">

                                                <form
                                                    action="{{route('orders.status.update',['cart' => $cart, 'newStatus' => CartStatus::SHIPPING->value])}}"
                                                    method="post">
                                                    @method("PATCH")
                                                    @csrf

                                                    <div class="flex items-center justify-end mt-4">
                                                        <x-primary-button
                                                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('Shipping') }}
                                                        </x-primary-button>
                                                    </div>
                                                </form>

                                            </td>
                                            <td class="px-6 py-4">
                                                #
                                            </td>
                                        @endif
                                        @if($cart->status === CartStatus::SHIPPING->value)
                                            <td class="px-6 py-4">
                                                <form
                                                    action="{{route('orders.status.update',['cart' => $cart, 'newStatus' => CartStatus::DELIVERED->value])}}"
                                                    method="post">
                                                    @method("PATCH")
                                                    @csrf

                                                    <div class="flex items-center justify-end mt-4">
                                                        <x-primary-button
                                                            class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                                            {{ __('Delivered') }}
                                                        </x-primary-button>
                                                    </div>
                                                </form>

                                            </td>
                                            <td class="px-6 py-4">
                                                #
                                            </td>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>

                    </div>
                    <div class="p-2">
                        <form action="">
                            @php
                                $statuses=CartStatus::getValues();
                               $last= array_key_last($statuses);
                                unset($statuses[$last]);
                            @endphp
                            <select name="filter_status">
                                @foreach($statuses as $status)
                                    <option value="{{$status}}">{{ ucfirst($status)}}</option>
                                @endforeach
                            </select>
                            <x-primary-button
                                class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Filter By Status') }}
                            </x-primary-button>
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
                Are you sure you want to cancel the order?
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
                    {{ __('Yes, Cancel') }}
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

        document.forms["cancelForm"].submit();


    }
</script>
