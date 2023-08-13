<?php

namespace App\Filament\Resources\MenuPlanResource\RelationManagers;

use Filament\Forms;
use App\Models\Menu;
use App\Models\MenuPlanMenu;
use Filament\Tables;
use App\Models\MenuType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class MenuPlanMenuRelationManager extends RelationManager
{
    protected static string $relationship = 'menus';

    protected static ?string $recordTitleAttribute = 'Menus';

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
                    ->label('Pilih Menu')
                    ->searchable()
                    ->required()
                    ->options(function ($get) {
                        $menuType = $get('menu_type_id');

                        if ($menuType) {
                            return Menu::where('menu_type_id', $menuType)
                                ->has('items')
                                ->get()
                                ->pluck('name', 'id')
                                ->toArray();
                        }
                    })
                    ->unique(MenuPlanMenu::class, column: 'menu_id', ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu.menuType.name')
                    ->label('Tipe Menu'),
                Tables\Columns\TextColumn::make('menu.name')
                    ->label('Nama Menu'),
                Tables\Columns\TextColumn::make('menu.grammage')
                    ->label('Grammage')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
