<?php

namespace App\Filament\Resources\VendorResource\Pages;

use App\Filament\Resources\VendorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListVendors extends ListRecords
{
    protected static string $resource = VendorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make()
                ->fields([
                    ImportField::make('code'),
                    ImportField::make('name'),
                    ImportField::make('contact'),
                    ImportField::make('email'),
                    ImportField::make('address'),
                    ImportField::make('country'),
                    ImportField::make('province'),
                    ImportField::make('city')
                ])
        ];
    }
}
