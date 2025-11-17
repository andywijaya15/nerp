<?php

namespace App\Filament\Clusters\MasterData\Resources\AreaResource\Pages;

use App\Filament\Clusters\MasterData\Resources\AreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArea extends EditRecord
{
    protected static string $resource = AreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
