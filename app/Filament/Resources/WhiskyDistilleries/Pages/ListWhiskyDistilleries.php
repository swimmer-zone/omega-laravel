<?php

namespace App\Filament\Resources\WhiskyDistilleries\Pages;

use App\Filament\Resources\WhiskyDistilleries\WhiskyDistilleryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWhiskyDistilleries extends ListRecords
{
    protected static string $resource = WhiskyDistilleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
