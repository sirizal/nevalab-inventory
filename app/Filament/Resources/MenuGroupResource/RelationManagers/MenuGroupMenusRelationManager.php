<?php

namespace App\Filament\Resources\MenuGroupResource\RelationManagers;

use Filament\Forms;
use App\Models\Menu;
use Filament\Tables;
use App\Models\MenuType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MenuGroupMenusRelationManager extends RelationManager
{
    protected static string $relationship = 'menuGroupMenus';

    protected static ?string $recordTitleAttribute = 'menu_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('menu_type_id')
                    ->label('Menu Type')
                    ->options(MenuType::all()->pluck('name', 'id')->toArray())
                    ->reactive()
                    ->searchable(),
                Forms\Components\Select::make('menu_id')
                    ->label('Menu')
                    ->searchable()
                    ->options(function ($get) {
                        return Menu::where('menu_type_id', $get('menu_type_id'))
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray();
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu.menu_type.name')->label('Menu Type'),
                Tables\Columns\TextColumn::make('menu.name')->label('Menu Name'),
                Tables\Columns\TextColumn::make('menu.grammage')->label('Grammage')
            ])
            ->filters([
                //e23CV                                        
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
