<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuGroupResource\Pages;
use App\Filament\Resources\MenuGroupResource\RelationManagers;
use App\Filament\Resources\MenuGroupResource\RelationManagers\MenuGroupMenusRelationManager;
use App\Models\MenuGroup;
use App\Models\MenuTime;
use App\Models\ProductGroup;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuGroupResource extends Resource
{
    protected static ?string $model = MenuGroup::class;

    protected static ?string $navigationGroup = 'Food Menu';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_group_id')
                    ->label('Product Group')
                    ->options(ProductGroup::all()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('menu_time_id')
                    ->label('Menu Time')
                    ->options(MenuTime::all()->pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_group.name'),
                Tables\Columns\TextColumn::make('menu_time.name'),
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\ImageColumn::make('image'),

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
            MenuGroupMenusRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuGroups::route('/'),
            'create' => Pages\CreateMenuGroup::route('/create'),
            'edit' => Pages\EditMenuGroup::route('/{record}/edit'),
        ];
    }
}
