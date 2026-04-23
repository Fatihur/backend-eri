<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\JsonResponse;

class SchoolClassController extends Controller
{
    public function index(): JsonResponse
    {
        $classes = SchoolClass::orderBy('order')->get();

        return response()->json([
            'data' => $classes,
            'message' => 'Success',
        ]);
    }
}
