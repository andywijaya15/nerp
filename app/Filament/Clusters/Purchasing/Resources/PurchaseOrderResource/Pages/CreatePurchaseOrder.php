<?php

namespace App\Filament\Clusters\Purchasing\Resources\PurchaseOrderResource\Pages;

use App\Filament\Clusters\Purchasing\Resources\PurchaseOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
