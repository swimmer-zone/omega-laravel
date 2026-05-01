<?php

namespace App\Filament\Resources\WhiskyTastings\Pages;

use App\Filament\Resources\WhiskyTastings\WhiskyTastingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWhiskyTastings extends ListRecords
{
    protected static string $resource = WhiskyTastingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
