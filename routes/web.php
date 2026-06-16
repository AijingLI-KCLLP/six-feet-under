<?php

use App\Http\Controllers\WallController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WallController::class, 'index']);
Route::post('/posts', [WallController::class, 'store']);
Route::post('/posts/{post}/kudo', [WallController::class, 'kudo']);
