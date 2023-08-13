<?php

namespace App\Filament\Resources\StorageTypeResource\Pages;

use App\Filament\Resources\StorageTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorageType extends EditRecord
{
    protected static string $resource = StorageTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
