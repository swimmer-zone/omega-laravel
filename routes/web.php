<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    dd(config('livewire.temporary_file_upload.rules'));
});
