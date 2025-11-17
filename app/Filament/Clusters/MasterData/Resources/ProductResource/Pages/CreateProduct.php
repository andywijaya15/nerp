<?php

namespace App\Filament\Clusters\MasterData\Resources\ProductResource\Pages;

use App\Filament\Clusters\MasterData\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
