<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categories = Category::where('class_id', $request->query('class_id'))
            ->orderBy('order')
            ->get();

        return response()->json([
            'data' => $categories,
            'message' => 'Success',
        ]);
    }
}
