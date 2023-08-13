<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Site;
use Filament\Tables;
use App\Models\MenuPlan;
use App\Models\ProductType;
use App\Models\StoreRequest;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StoreRequestResource\Pages;
use App\Filament\Resources\StoreRequestResource\RelationManagers;
use App\Filament\Resources\StoreRequestResource\RelationManagers\StoreRequestItemRelationManager;

class StoreRequestResource extends Resource
{
    protected static ?string $model = StoreRequest::class;

    protected static ?string $navigationGroup = 'Store Request';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->columns(3)
                            ->schema([
                                DatePicker::make('request_delivery_date')
                                    ->required()
                                    ->format('Y-m-d'),
                                Select::make('product_type_id')
                                    ->label('Product Type')
                                    ->options(ProductType::all()->pluck('name', 'id')->toArray())
                                    ->required(),
                                Select::make('site_id')
                                    ->label('Site')
                                    ->options(Site::all()->pluck('name', 'id')->toArray())
                                    ->required(),
                                Select::make('menu_plan_id')
                                    ->label('Menu Plan')
                                    ->options(MenuPlan::all()->pluck('code', 'id')->toArray()),
                                TextInput::make('remarks')
                                    ->columnSpan(2)
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')
                    ->sortable(),
                TextColumn::make('request_delivery_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Request No')
                    ->sortable()
            ])->defaultSort('id', 'desc')
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
            StoreRequestItemRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreRequests::route('/'),
            'create' => Pages\CreateStoreRequest::route('/create'),
            'edit' => Pages\EditStoreRequest::route('/{record}/edit'),
        ];
    }
}
