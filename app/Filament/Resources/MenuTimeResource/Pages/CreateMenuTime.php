<?php

namespace App\Filament\Resources\MenuTimeResource\Pages;

use App\Filament\Resources\MenuTimeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuTime extends CreateRecord
{
    protected static string $resource = MenuTimeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
