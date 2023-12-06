<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Http\Requests\Discount\UpdateDiscountRequest;
use App\Models\Discount;
use App\Models\User;
use App\Notifications\Discount\DiscountEmailNotification;
use App\Notifications\Discount\DiscountSMSNotification;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('discount.index', [
            'discounts' => Discount::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discount.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        try {
            $discount = Discount::query()->create($request->validated());
            Notification::send(User::all()->filter(fn($user) => $user->restaurant === null), new DiscountEmailNotification($discount));
            Notification::send(User::all()->filter(fn($user) => $user->restaurant === null), new DiscountSMSNotification($discount));
        } catch (QueryException $e) {
            Log::error('Error Creating new Discount' . $e->getMessage());
            return view('error.500',['route',route('discounts.index')]);
        }
        return redirect()->route('discounts.index')->with('success', "a new discount code created");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        return view('discount.edit', [
            'discount' => $discount
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        try {
            $discount->update($request->validated());
        }catch (QueryException $e){
            Log::error('Error Updating Discount' . $e->getMessage());
            return view('error.500',['route',route('discounts.index')]);
        }

        return redirect()->route('discounts.index')->with('success', "Discount with id {$discount->id} has been updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        try {
            $discount->delete();
        } catch (QueryException $e) {
            Log::error('Error Creating new Discount' . $e->getMessage());
            return view('error.500',['route',route('discounts.index')]);
        }
        return redirect()->route('discounts.index')->with('success', "Discount with id {$discount->id} has been deleted");
    }
}
