<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\StoreBannerRequest;
use App\Http\Requests\Banner\UpdateBannerRequest;
use App\Models\Banner;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Banner::class,'banner');
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

        Banner::query()->create($request->validated());
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

        $banner->update($request->validated());
        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {

        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully');
    }
}
