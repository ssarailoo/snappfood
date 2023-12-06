<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;
use App\Models\Banner;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Banner::class, 'banner');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('banner.index', [
            'banners' => Banner::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ;
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        try {
            $banner = Banner::query()->create($request->validated());
            $banner->image()->create(['url' => $request->file('url')]);
        }catch (QueryException $e){
            Log::error('Error Creating Banner'. $e->getMessage());
            return view('error.500', ['route' => route('banners.index')]);
        }

        return redirect()->route('banners.index')->with('success', 'Banner created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {

        return view('banner.show', [
            'banner' => $banner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {

        return view('banner.edit', [
            'banner' => $banner
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        try {
            $banner->update($request->validated());
            $banner->image->update(['url' => $request->file('url')]);
        }catch (QueryException $e){
            Log::error('Error Updating Banner'. $e->getMessage());
            return view('error.500', ['route' => route('banners.index')]);
        }

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        try {
            $banner->delete();
        }catch (QueryException $e){
            Log::error('Error Deleting Banner'. $e->getMessage());
            return view('error.500', ['route' => route('banners.index')]);
        }

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully');
    }
}
