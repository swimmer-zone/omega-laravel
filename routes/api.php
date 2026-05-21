<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\DistilleryController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\MusicController;
use App\Http\Controllers\Api\SocialController;
use App\Http\Controllers\Api\TrackPlayController;
use App\Http\Controllers\Api\VisitedCityController;
use App\Http\Controllers\Api\VisitedCountryController;
use App\Http\Controllers\Api\WhiskyController;

// Home
Route::get('/home', [HomeController::class, 'index']);
Route::get('/social', [SocialController::class, 'index']);

Route::get('/music', [MusicController::class, 'index']);
Route::post('/tracks/{track}/play/start', [TrackPlayController::class, 'start']);
Route::patch('/track-plays/{trackPlay}', [TrackPlayController::class, 'update']);

// Resume

// Travels
Route::get('/travels', [BlogController::class, 'travels']);
Route::get('/travels/{slug}', [BlogController::class, 'travel']);
Route::get('/cities', [VisitedCityController::class, 'index']); // @todo
Route::get('/countries', [VisitedCountryController::class, 'index']);

// Whisky
Route::get('/whisky', [WhiskyController::class, 'index']);
Route::get('/distilleries', [DistilleryController::class, 'index']); // @todo

// DIY
Route::get('/diy', [BlogController::class, 'diy']);
Route::get('/diy/{slug}', [BlogController::class, 'diyShow']);

// Archive
Route::get('/tutorials', [BlogController::class, 'tutorials']);
Route::get('/tutorials/{slug}', [BlogController::class, 'tutorialShow']);

Route::get('/archive', [BlogController::class, 'archive']);
Route::get('/archive/{slug}', [BlogController::class, 'archiveShow']);
