<?php

namespace App\Filament\Clusters\MasterData\Resources\WarehouseResource\Pages;

use App\Filament\Clusters\MasterData\Resources\WarehouseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarehouse extends EditRecord
{
    protected static string $resource = WarehouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
