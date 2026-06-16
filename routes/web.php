<?php

use App\Http\Controllers\WallController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WallController::class, 'index']);
