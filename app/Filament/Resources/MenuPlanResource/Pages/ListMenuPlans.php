<?php

namespace App\Filament\Resources\MenuPlanResource\Pages;

use App\Filament\Resources\MenuPlanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenuPlans extends ListRecords
{
    protected static string $resource = MenuPlanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
