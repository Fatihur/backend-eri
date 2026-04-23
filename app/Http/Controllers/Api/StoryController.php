<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\JsonResponse;

class StoryController extends Controller
{
    public function show(int $materialId): JsonResponse
    {
        $story = Story::where('material_id', $materialId)
            ->with('scenes.signLanguageVideo')
            ->first();

        if (!$story) {
            return response()->json(['message' => 'Story not found'], 404);
        }

        return response()->json([
            'data' => $story,
            'message' => 'Success',
        ]);
    }
}
