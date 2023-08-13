<?php

namespace App\Filament\Resources\VendorPurchaseRequestResource\Pages;

use App\Filament\Resources\VendorPurchaseRequestResource;
use App\Models\PurchaseRequest;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListVendorPurchaseRequests extends ListRecords
{
    protected static string $resource = VendorPurchaseRequestResource::class;

    protected function getTableQuery(): Builder
    {
        return PurchaseRequest::query()
            ->where('vendor_id',1);
    }

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
