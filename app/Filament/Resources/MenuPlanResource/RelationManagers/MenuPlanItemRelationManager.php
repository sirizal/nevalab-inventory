<?php

namespace App\Filament\Resources\MenuPlanResource\RelationManagers;

use App\Models\MenuPlanItem;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MenuPlanItemRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'Menu Items';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('items')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menuItem.item.code')
                    ->label('Code'),
                Tables\Columns\TextColumn::make('menuItem.item.description')
                    ->label('Description'),
                Tables\Columns\TextColumn::make('menuItem.grammage')
                    ->label('Item Grammage'),
                Tables\Columns\TextColumn::make('total_gramage')
                    ->getStateUsing(function (MenuPlanItem $record): string {
                        $total_grammage =  ($record->menuItem->grammage * $record->menuPlan->estimate_pob);

                        return number_format($total_grammage, 0, '.', ',');
                    })

            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
