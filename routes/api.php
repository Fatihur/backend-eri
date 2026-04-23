<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MaterialController;
use App\Http\Controllers\Api\ReflectionController;
use App\Http\Controllers\Api\SchoolClassController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\Video360Controller;
use Illuminate\Support\Facades\Route;

Route::get('/classes', [SchoolClassController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/materials', [MaterialController::class, 'index']);
Route::get('/materials/{material}', [MaterialController::class, 'show']);
Route::get('/stories/{materialId}', [StoryController::class, 'show']);
Route::get('/videos-360/{materialId}', [Video360Controller::class, 'show']);
Route::get('/reflections/{materialId}', [ReflectionController::class, 'show']);
