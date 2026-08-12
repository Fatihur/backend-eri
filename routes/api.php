<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/items', [ItemController::class, 'index']);
Route::get('/items/latest', [ItemController::class, 'latest']);
Route::get('/items/{item}', [ItemController::class, 'show']);

Route::get('/file', [FileController::class, 'serve']);
