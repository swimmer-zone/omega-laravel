<?php

namespace App\Filament\Widgets;

use App\Models\Track;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularTracksTable extends BaseWidget
{
    protected static ?string $heading = 'Popular tracks';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Track::query()
                    ->orderByDesc('plays')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('plays')
                    ->sortable(),

                Tables\Columns\TextColumn::make('completed_plays')
                    ->label('Completed')
                    ->sortable(),

                Tables\Columns\TextColumn::make('completion_rate')
                    ->label('Completion')
                    ->state(function (Track $record): string {
                        if ($record->plays === 0) {
                            return '0%';
                        }

                        return round(($record->completed_plays / $record->plays) * 100) . '%';
                    }),

                Tables\Columns\TextColumn::make('total_listen_seconds')
                    ->label('Listening time')
                    ->formatStateUsing(function (int $state): string {
                        $hours = floor($state / 3600);
                        $minutes = floor(($state % 3600) / 60);

                        return "{$hours}h {$minutes}m";
                    }),

                Tables\Columns\TextColumn::make('last_played_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
