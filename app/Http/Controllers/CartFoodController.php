<?php

namespace App\Http\Controllers;

use App\Models\CartFood;
use App\Http\Requests\StoreCartFoodRequest;
use App\Http\Requests\UpdateCartFoodRequest;

class CartFoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartFoodRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CartFood $cartFood)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartFood $cartFood)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartFoodRequest $request, CartFood $cartFood)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartFood $cartFood)
    {
        //
    }
}
