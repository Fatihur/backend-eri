<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Story::query()->with('category');

        if ($categoryId = $request->query('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($request->boolean('has_panorama')) {
            $query->has('scenes');
        }

        $stories = $query->orderByDesc('published_at')->orderByDesc('id')->get();

        return response()->json([
            'data' => $stories,
            'message' => 'Success',
        ]);
    }

    public function latest(): JsonResponse
    {
        $stories = Story::with('category')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => $stories,
            'message' => 'Success',
        ]);
    }

    public function show(Story $story): JsonResponse
    {
        $story->load(['category', 'scenes.hotspots']);

        return response()->json([
            'data' => $story,
            'message' => 'Success',
        ]);
    }

    public function panorama(Story $story): JsonResponse
    {
        $story->load(['scenes.hotspots']);

        return response()->json([
            'data' => [
                'story_id' => $story->id,
                'title' => $story->title,
                'scenes' => $story->scenes,
            ],
            'message' => 'Success',
        ]);
    }
}
