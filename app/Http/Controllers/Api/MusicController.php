<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function index()
    {
        return Track::query()
            ->get();
    }

    public function show($slug)
    {
        return Track::where('slug', $slug)->firstOrFail();
    }
}
