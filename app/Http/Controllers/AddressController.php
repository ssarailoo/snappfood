<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\AddressUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group User Management Addresses
 */
class AddressController extends Controller
{

    /**
     * Retrieve a list of addresses for the authenticated user.
     * @apiResourceCollection  App\Http\Resources\AddressResource
     * @apiResourceModel App\Models\Address
     */
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return response(AddressResource::collection($addresses), 200);
    }

    /**
     * Display a specific address if the user has the necessary permission (address must belong to the user's addresses).
     * @apiResource App\Http\Resources\AddressResource
     * @apiResourceModel App\Models\Address
     */
    public function show(Address $address)
    {
        $this->authorize('myAddress', $address);
        return response(new AddressResource($address), 200);

    }

    /**
     * Store a newly created resource
     * @response 201 scenario="Address added successfully" {
     *      "message": "Address added successfully"
     *  }
     * @response 422 scenario="Validation errors" {
     *      "message": "The given data was invalid.",
     *      "errors": {
     *          "title": ["The title field is required."],
     *          "address": ["The address field is required."],
     *          "longitude": ["The longitude field is required.", "The longitude must be between -90 and 90."],
     *          "latitude": ["The latitude field is required.", "The latitude must be between -90 and 90."],
     *      }
     *  }
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
     * Update an address with the provided data if the user has the necessary permission (address must belong to the user's addresses).
     * @response 200 {
     *      "message": "The address has been updated successfully"
     *  }
     * @response 403 {
     *      "message": "You are not authorized to update this address"
     *  }
     * @response 404 {
     *      "message": "The specified address does not exist"
     *  }
     */

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $this->authorize('myAddress', $address);
        $address->update($request->validated());
        return response([
            'message' => $address->title . "has been updated"
        ], 200);
    }

    /**
     *  Delete an address if the user has the necessary permission (address must belong to the user's addresses).
     * @response 204
     * @response 403 {
     *      "message": "You are not authorized to delete this address"
     *  }
     * @response 404 {
     *      "message": "The specified address does not exist"
     *  }
     */
    public function destroy(Address $address)
    {
        $this->authorize('myAddress', $address);
        $address->delete();
        return response([
            'message' => $address->title . "has been deleted"
        ], 204);
    }

    /**
     * Update the current address for the authenticated user.
     * Update the user's current address if they have the necessary permission (address must belong to the user's addresses).
     * @response 200 {
     *     "message": "Current address updated successfully"
     * }
     * @response 403 {
     *     "message": "You are not authorized to update the current address"
     * }
     * @response 404 {
     *     "message": "The specified address does not exist"
     * }
     */
    public function updateUserAddress(Address $address)
    {
        $this->authorize('myAddress', $address);
        Auth::user()->update([
            'current_address' => $address->id
        ]);
        return response([
            'message' => 'current address updated successfully'
        ], 200);
    }
}
