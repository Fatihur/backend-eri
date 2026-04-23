<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $materials = Material::where('category_id', $request->query('category_id'))->get();

        return response()->json([
            'data' => $materials,
            'message' => 'Success',
        ]);
    }

    public function show(Material $material): JsonResponse
    {
        $material->load('galleries');

        return response()->json([
            'data' => $material,
            'message' => 'Success',
        ]);
    }
}
