<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {

        return view('dashboard', [
            'carts' => Auth::user()->restaurant->carts()
//                ->whereNotNull('status')
                ->where('status', '!=', 'received')
                ->get(),
        ]);
    }


}
