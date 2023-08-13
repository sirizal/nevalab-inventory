<?php

namespace App\Filament\Resources\MenuTimeResource\Pages;

use App\Filament\Resources\MenuTimeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenuTimes extends ListRecords
{
    protected static string $resource = MenuTimeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
