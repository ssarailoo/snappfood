<?php

namespace App\Http\Controllers;



use App\Models\Food\Food;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class MaterialController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        Log::info('Search Query:', ['query' => $query]);

        $materials = Material::where('name', 'like', "%$query%")->get(['id', 'name']);
        Log::info('Search Results:', $materials->toArray());

        return response()->json($materials);
    }

//    public function create(Request $request)
//    {
//        $materialName = $request->input('name');
//
//        Log::info('Create Material:', ['name' => $materialName]);
//
//        // Check if the material already exists
//        $material = Material::query()->firstOrCreate(['name' => $materialName]);
//        Log::info('Material Created:', $material->toArray());
//
//
//        return response()->json(['id' => $material->id, 'text' => $material->name]);
//    }
}

