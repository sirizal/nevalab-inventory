<?php

namespace App\Filament\Resources\StorageTypeResource\Pages;

use App\Filament\Resources\StorageTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorageTypes extends ListRecords
{
    protected static string $resource = StorageTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
