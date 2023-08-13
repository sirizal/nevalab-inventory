<?php

namespace App\Filament\Resources\MenuPlanResource\Pages;

use App\Filament\Resources\MenuPlanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuPlan extends CreateRecord
{
    protected static string $resource = MenuPlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
