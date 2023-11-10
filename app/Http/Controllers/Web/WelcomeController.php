<?php

namespace App\Http\Controllers\Web;

use App\Models\Banner;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome', [
            'banners' => Banner::all()
        ]);
    }

}
