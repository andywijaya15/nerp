<?php

namespace App\Filament\Clusters\MasterData\Resources\SupplierResource\Pages;

use App\Filament\Clusters\MasterData\Resources\SupplierResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuppliers extends ListRecords
{
    protected static string $resource = SupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
