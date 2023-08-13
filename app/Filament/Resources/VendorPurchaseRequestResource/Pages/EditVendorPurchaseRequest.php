<?php

namespace App\Filament\Resources\VendorPurchaseRequestResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Carbon;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\VendorPurchaseRequestResource;

class EditVendorPurchaseRequest extends EditRecord
{
    protected static string $resource = VendorPurchaseRequestResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['delivery_user'] = auth()->id();
        $data['status'] = 1;
        $data['updated_at'] = Carbon::now();

        return $data;
    }

    protected function getActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
