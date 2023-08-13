<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuTypeResource\Pages;
use App\Filament\Resources\MenuTypeResource\RelationManagers;
use App\Filament\Resources\MenuTypeResource\RelationManagers\MenusRelationManager;
use App\Models\MenuType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuTypeResource extends Resource
{
    protected static ?string $model = MenuType::class;

    protected static ?string $navigationGroup = 'Food Menu';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('menus_count')
                    ->label('Menu Counts')
                    ->counts('menus')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MenusRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuTypes::route('/'),
            'create' => Pages\CreateMenuType::route('/create'),
            'edit' => Pages\EditMenuType::route('/{record}/edit'),
        ];
    }
}
