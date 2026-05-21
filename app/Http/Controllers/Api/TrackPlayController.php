<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\TrackPlay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrackPlayController extends Controller
{
    public function start(Request $request, Track $track)
    {
        $data = $request->validate([
            'visitor_id' => ['nullable', 'string', 'max:100'],
            'duration_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $play = TrackPlay::create([
            'track_id' => $track->id,
            'visitor_id' => $data['visitor_id'] ?? null,
            'duration_seconds' => $data['duration_seconds'] ?? null,
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            'ip_hash' => hash('sha256', $request->ip() . config('app.key')),
        ]);

        return response()->json([
            'id' => $play->id,
        ]);
    }

    public function update(Request $request, TrackPlay $trackPlay)
    {
        $data = $request->validate([
            'played_seconds' => ['required', 'integer', 'min:0'],
            'duration_seconds' => ['nullable', 'integer', 'min:0'],
            'completed' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($trackPlay, $data) {
            $previousSeconds = $trackPlay->played_seconds;

            $trackPlay->played_seconds = max(
                $trackPlay->played_seconds,
                $data['played_seconds']
            );

            if (isset($data['duration_seconds'])) {
                $trackPlay->duration_seconds = $data['duration_seconds'];
            }

            if (($data['completed'] ?? false) === true) {
                $trackPlay->completed = true;
            }

            if (! $trackPlay->counted && $trackPlay->played_seconds >= 10) {
                $trackPlay->counted = true;

                $trackPlay->track()->increment('plays');
                $trackPlay->track()->update([
                    'last_played_at' => now(),
                ]);
            }

            if ($trackPlay->completed && ! $trackPlay->getOriginal('completed')) {
                $trackPlay->track()->increment('completed_plays');
            }

            $extraSeconds = max(0, $trackPlay->played_seconds - $previousSeconds);

            if ($extraSeconds > 0) {
                $trackPlay->track()->increment('total_listen_seconds', $extraSeconds);
            }

            $trackPlay->save();
        });

        return response()->json([
            'success' => true,
        ]);
    }
}
