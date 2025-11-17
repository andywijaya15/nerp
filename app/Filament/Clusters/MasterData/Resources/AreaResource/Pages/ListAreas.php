<?php

namespace App\Filament\Clusters\MasterData\Resources\AreaResource\Pages;

use App\Filament\Clusters\MasterData\Resources\AreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAreas extends ListRecords
{
    protected static string $resource = AreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
