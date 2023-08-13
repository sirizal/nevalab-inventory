<?php

namespace App\Filament\Resources\PurchaseRequestResource\Pages;

use Filament\Pages\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PurchaseRequestResource;

class ListPurchaseRequests extends ListRecords
{
    protected static string $resource = PurchaseRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('importExcel')
                ->action('openImportExcel')
                ->form([
                    FileUpload::make('upload')
                        ->disk('local')
                        ->directory('uploads')
                        ->preserveFilenames()
                        ->acceptedFileTypes(['text/csv'])
                ])
        ];
    }
}
