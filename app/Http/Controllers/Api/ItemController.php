<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Item::query()->with('category');

            if ($categoryId = $request->query('category_id')) {
                $query->where('category_id', $categoryId);
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

            $items = $query
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'data' => $items,
                'message' => 'Success',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => 'Gagal memuat item',
            ], 500);
        }
    }

    public function latest(): JsonResponse
    {
        try {
            $items = Item::with('category')
                ->whereNotNull('published_at')
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->limit(10)
                ->get();

            return response()->json([
                'data' => $items,
                'message' => 'Success',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => 'Gagal memuat item terbaru',
            ], 500);
        }
    }

    public function show(Item $item): JsonResponse
    {
        try {
            $item->load('category');

            return response()->json([
                'data' => $item,
                'message' => 'Success',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => null,
                'message' => 'Gagal memuat detail item',
            ], 500);
        }
    }
}
