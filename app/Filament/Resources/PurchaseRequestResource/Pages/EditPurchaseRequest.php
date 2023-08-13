<?php

namespace App\Filament\Resources\PurchaseRequestResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Support\Carbon;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PurchaseRequestResource;

class EditPurchaseRequest extends EditRecord
{
    protected static string $resource = PurchaseRequestResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['modify_user'] = auth()->id();
        $data['updated_at'] = Carbon::now();

        return $data;
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
