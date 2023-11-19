<?php

namespace App\Http\Controllers\Web;



use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MaterialController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = $request->input('q');
        Log::info('Search Query:', ['query' => $query]);

        $materials = Material::where('name', 'like', "%$query%")->get(['id', 'name']);
        Log::info('Search Results:', $materials->toArray());

        return response()->json($materials);
    }




}

