<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Automatically registers index, store, show, update, and destroy routes
Route::apiResource('posts', PostController::class);