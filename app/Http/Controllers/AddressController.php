<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Models\Address;
use App\Models\AddressUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return response([
            'addresses' => $addresses,

        ], 201);
    }


    public function show(Address $address)
    {
        $this->authorize('myAddress', $address);
        return response([
            'address' => $address
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $address = Address::query()->create($request->validated());
        AddressUser::query()->create([
            'user_id' => Auth::user()->id,
            'address_id' => $address->id
        ]);
        return response([
            'message' => 'Address added successfully'
        ], 201);

    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $this->authorize('myAddress', $address);
        $address->update($request->validated());
        return response([
            'message' => $address->title . "has been updated"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $this->authorize('myAddress', $address);
        $address->delete();
        return response([
            'message' => $address->title . "has been deleted"
        ], 201);
    }

    public function updateUserAddress(Address $address)
    {
        $this->authorize('myAddress', $address);
        Auth::user()->update([
            'current_address' => $address->id
        ]);
        return response([
            'message' => 'current address updated successfully'
        ]);
    }
}
