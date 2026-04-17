<?php

namespace App\Filament\Resources\Travels\Pages;

use App\Filament\Resources\Travels\TravelResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTravel extends ViewRecord
{
    protected static string $resource = TravelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
