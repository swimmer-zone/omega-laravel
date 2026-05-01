<?php

namespace App\Filament\Resources\Homes\Pages;

use App\Filament\Resources\Homes\HomeResource;
use App\Models\Home;
use Filament\Resources\Pages\ListRecords;

class ListHomes extends ListRecords
{
    protected static string $resource = HomeResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = Home::first();

        if ($record) {
            $this->redirect(
                HomeResource::getUrl('edit', ['record' => $record])
            );
        }
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
