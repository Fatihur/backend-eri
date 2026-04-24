<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\StoryController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/stories', [StoryController::class, 'index']);
Route::get('/stories/latest', [StoryController::class, 'latest']);
Route::get('/stories/{story}', [StoryController::class, 'show']);
Route::get('/stories/{story}/panorama', [StoryController::class, 'panorama']);
