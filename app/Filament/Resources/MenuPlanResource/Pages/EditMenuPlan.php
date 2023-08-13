<?php

namespace App\Filament\Resources\MenuPlanResource\Pages;

use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MenuPlanResource;
use Filament\Facades\Filament;

class EditMenuPlan extends EditRecord
{
    protected static string $resource = MenuPlanResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
            Action::make('Duplicates')->color('danger')
                ->visible(fn () => $this->record->menus()->count())
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->replicateRow();
                    Filament::notify('success', 'Data telah di duplikasi');
                    redirect(MenuPlanResource::getUrl('index'));
                }),
            Action::make('Store Request')->color('primary')
                ->visible(fn () => $this->record->storeRequests()->count() ? '0' : '1')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->createStoreRequest();
                    Filament::notify('success', 'Store Request telah di buat');
                    redirect(MenuPlanResource::getUrl('edit', ['record' => $this->record->id]));
                })
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
