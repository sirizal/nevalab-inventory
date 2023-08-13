<?php

namespace App\Filament\Resources\UomResource\Pages;

use App\Filament\Resources\UomResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListUoms extends ListRecords
{
    protected static string $resource = UomResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('code'),
                    ImportField::make('name')
                ])
        ];
    }
}
