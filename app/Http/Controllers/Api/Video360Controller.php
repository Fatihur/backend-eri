<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video360;
use Illuminate\Http\JsonResponse;

class Video360Controller extends Controller
{
    public function show(int $materialId): JsonResponse
    {
        $videos = Video360::where('material_id', $materialId)->get();

        return response()->json([
            'data' => $videos,
            'message' => 'Success',
        ]);
    }
}
