<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function serve(Request $request)
    {
        $path = $request->query('path');

        if (!$path) {
            return response()->json(['error' => 'Path not provided'], 400);
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($path)) {
            return response()->json([
                'error' => 'File not found',
                'path' => $path,
                'files_in_dir' => $disk->files(dirname($path))
            ], 404);
        }

        $fullPath = $disk->path($path);
        $size = filesize($fullPath);
        $mime = $disk->mimeType($path) ?: 'application/octet-stream';

        $range = $request->header('Range');
        if ($range && preg_match('/bytes=(\d*)-(\d*)/', $range, $m)) {
            $start = $m[1] === '' ? null : (int) $m[1];
            $end = $m[2] === '' ? null : (int) $m[2];

            if ($start === null) {
                // Suffix range: bytes=-N (N bytes terakhir)
                $start = max(0, $size - (int) $end);
                $end = $size - 1;
            } else {
                if ($end === null || $end >= $size) {
                    $end = $size - 1;
                }
            }

            if ($start > $end || $start >= $size) {
                return response('', 416, ['Content-Range' => "bytes */$size"]);
            }

            $stream = fopen($fullPath, 'rb');
            fseek($stream, $start);
            $length = $end - $start + 1;

            return response()->stream(function () use ($stream, $length) {
                $sent = 0;
                while ($sent < $length && !feof($stream)) {
                    $read = min(8192, $length - $sent);
                    echo fread($stream, $read);
                    $sent += $read;
                }
                fclose($stream);
            }, 206, [
                'Content-Type' => $mime,
                'Content-Length' => $length,
                'Content-Range' => "bytes $start-$end/$size",
                'Accept-Ranges' => 'bytes',
                'Access-Control-Allow-Origin' => '*',
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        return $disk->response($path, null, [
            'Access-Control-Allow-Origin' => '*',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
