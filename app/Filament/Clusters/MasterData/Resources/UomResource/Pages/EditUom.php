<?php

namespace App\Filament\Clusters\MasterData\Resources\UomResource\Pages;

use App\Filament\Clusters\MasterData\Resources\UomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUom extends EditRecord
{
    protected static string $resource = UomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
