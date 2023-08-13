<?php

namespace App\Filament\Resources\MenuTypeResource\Pages;

use App\Filament\Resources\MenuTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenuType extends EditRecord
{
    protected static string $resource = MenuTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
