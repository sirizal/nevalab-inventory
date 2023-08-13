<?php

namespace App\Filament\Resources\MenuTypeResource\Pages;

use App\Filament\Resources\MenuTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuType extends CreateRecord
{
    protected static string $resource = MenuTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
