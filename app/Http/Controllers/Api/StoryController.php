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
        try {
            $query = Story::query()
                ->with('category')
                ->withExists('scenes')
                ->withCount('scenes');

            if ($categoryId = $request->query('category_id')) {
                $query->where('category_id', $categoryId);
            }

            if ($request->boolean('has_panorama')) {
                $query->has('scenes');
            }

            if ($ids = $request->query('ids')) {
                $parsedIds = collect(explode(',', $ids))
                    ->map(fn ($v) => (int) trim($v))
                    ->filter(fn ($v) => $v > 0)
                    ->unique()
                    ->values();

                if ($parsedIds->isNotEmpty()) {
                    $query->whereIn('id', $parsedIds);
                } else {
                    return response()->json(['data' => [], 'message' => 'Success']);
                }
            }

            $stories = $query->orderByDesc('published_at')->orderByDesc('id')->get();

            return response()->json([
                'data' => $stories,
                'message' => 'Success',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => 'Gagal memuat cerita',
            ], 500);
        }
    }

    public function latest(): JsonResponse
    {
        try {
            $stories = Story::with('category')
                ->withExists('scenes')
                ->withCount('scenes')
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->limit(10)
                ->get();

            return response()->json([
                'data' => $stories,
                'message' => 'Success',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => 'Gagal memuat cerita terbaru',
            ], 500);
        }
    }

    public function show(Story $story): JsonResponse
    {
        try {
            $story->load(['category', 'scenes.hotspots']);

            return response()->json([
                'data' => $story,
                'message' => 'Success',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => null,
                'message' => 'Gagal memuat detail cerita',
            ], 500);
        }
    }

    public function panorama(Story $story): JsonResponse
    {
        try {
            $story->load(['scenes.hotspots']);

            return response()->json([
                'data' => [
                    'story_id' => $story->id,
                    'title' => $story->title,
                    'scenes' => $story->scenes,
                ],
                'message' => 'Success',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => null,
                'message' => 'Gagal memuat panorama',
            ], 500);
        }
    }
}
