<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TravelController;

Route::get('/travels', [TravelController::class, 'index']);
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/images', [ImageController::class, 'index']);
