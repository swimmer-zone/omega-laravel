<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function index()
    {
        return Section::all();
    }

    public function show($slug)
    {
        return Track::where('slug', $slug)->firstOrFail();
    }
}
