<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/storage/{path}', function (string $path) {
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    $fullPath = Storage::disk('public')->path($path);
    $mimeType = Storage::disk('public')->mimeType($path);

    return response()->file($fullPath, [
        'Content-Type' => $mimeType ?? 'application/octet-stream',
        'Access-Control-Allow-Origin' => '*',
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*');
