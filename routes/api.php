<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TravelController;

Route::get('/travels', [TravelController::class, 'index']);
Route::get('/travels/{slug}', [TravelController::class, 'show']);
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/music', [MusicController::class, 'index']);
Route::get('/track/{slug}', [MusicController::class, 'show']);
