<?php

namespace App\Filament\Widgets;

use App\Models\Track;
use App\Models\TrackPlay;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MusicStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalPlays = Track::sum('plays');
        $completedPlays = Track::sum('completed_plays');
        $totalSeconds = Track::sum('total_listen_seconds');

        $completionRate = $totalPlays > 0
            ? round(($completedPlays / $totalPlays) * 100)
            : 0;

        return [
            Stat::make('Total plays', number_format($totalPlays)),
            Stat::make('Completed plays', number_format($completedPlays)),
            Stat::make('Completion rate', $completionRate . '%'),
            Stat::make('Total listening time', $this->formatSeconds($totalSeconds)),
            Stat::make('Unique listeners', TrackPlay::distinct('visitor_id')->count('visitor_id')),
        ];
    }

    private function formatSeconds(int $seconds): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return "{$hours}h {$minutes}m";
    }
}
