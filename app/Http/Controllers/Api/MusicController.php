<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Track;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function index()
    {
        return Section::query()
            ->with(['tracks' => function ($query) {
                $query->orderBy('track_number');
            }])
            ->orderBy('id')
            ->get();
    }

    public function show($slug)
    {
        return Track::where('slug', $slug)->firstOrFail();
    }
}
