<?php

namespace App\Filament\Clusters\MasterData\Resources\LocatorResource\Pages;

use App\Filament\Clusters\MasterData\Resources\LocatorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocators extends ListRecords
{
    protected static string $resource = LocatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
