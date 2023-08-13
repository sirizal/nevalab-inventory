<?php

namespace App\Filament\Resources\MenuTypeResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\MenuTypeResource;
use Konnco\FilamentImport\Actions\ImportField;
use Konnco\FilamentImport\Actions\ImportAction;

class ListMenuTypes extends ListRecords
{
    protected static string $resource = MenuTypeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('name')
                ])
        ];
    }
}
