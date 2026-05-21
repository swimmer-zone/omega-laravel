<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackPlay extends Model
{
    protected $fillable = [
        'track_id',
        'visitor_id',
        'played_seconds',
        'duration_seconds',
        'counted',
        'completed',
        'user_agent',
        'ip_hash',
    ];
    
    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
