<?php

use Illuminate\Support\Facades\Route;
use App\Models\Track;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/test', function () {
//     dd(config('livewire.temporary_file_upload.rules'));
// });
Route::get('/test-track-id3/{track}', function (Track $track) {
    $path = Storage::disk('public')->path($track->file);

    if (! file_exists($path)) {
        dd('File does not exist', $path);
    }

    $analyzer = new getID3();
    $info = $analyzer->analyze($path);

    getid3_lib::CopyTagsToComments($info);

    dd([
        'stored_file' => $track->file,
        'full_path' => $path,
        'comments' => $info['comments'] ?? null,
        'tags' => $info['tags'] ?? null,
        'id3v2' => $info['id3v2'] ?? null,
    ]);
});
