<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;

class TrackPlayController extends Controller
{
    public function store(Track $track)
    {
        $track->increment('plays');

        return response()->json([
            'plays' => $track->plays,
        ]);
    }
}
