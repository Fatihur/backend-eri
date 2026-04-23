<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reflection;
use Illuminate\Http\JsonResponse;

class ReflectionController extends Controller
{
    public function show(int $materialId): JsonResponse
    {
        $reflections = Reflection::where('material_id', $materialId)
            ->with('options')
            ->get();

        return response()->json([
            'data' => $reflections,
            'message' => 'Success',
        ]);
    }
}
