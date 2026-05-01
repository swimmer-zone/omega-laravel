<?php

namespace App\Filament\Resources\VisitedCities\Pages;

use App\Filament\Resources\VisitedCities\VisitedCityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVisitedCities extends ListRecords
{
    protected static string $resource = VisitedCityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
