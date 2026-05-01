<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\DistilleryController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\TravelController;
use App\Http\Controllers\Api\VisitedCityController;
use App\Http\Controllers\Api\VisitedCountryController;
use App\Http\Controllers\Api\WhiskyController;

// Home
Route::get('/home', [HomeController::class, 'index']);
Route::get('/music', [MusicController::class, 'index']);
Route::get('/track/{slug}', [MusicController::class, 'show']);

// Resume

// Travels
Route::get('/travels', [TravelController::class, 'index']);
Route::get('/travels/{slug}', [TravelController::class, 'show']);
Route::get('/gallery/{slug}', [GalleryController::class, 'show']);
Route::get('/cities', [VisitedCityController::class, 'index']);
Route::get('/countries', [VisitedCountryController::class, 'index']);

// Whisky
Route::get('/whisky', [WhiskyController::class, 'index']);
Route::get('/distilleries', [DistilleryController::class, 'index']);

// DIY Cabinet

// Bookmarks
Route::get('/bookmarks', [BookmarkController::class, 'index']);

// Tutorials

// Blogs
