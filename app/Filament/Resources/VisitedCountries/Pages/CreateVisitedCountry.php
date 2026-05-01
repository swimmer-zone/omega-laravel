<?php

namespace App\Filament\Resources\VisitedCountries\Pages;

use App\Filament\Resources\VisitedCountries\VisitedCountryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVisitedCountry extends CreateRecord
{
    protected static string $resource = VisitedCountryResource::class;
}
