<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\MenuPlan;
use App\Models\MenuTime;
use App\Models\ProductGroup;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MenuPlanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MenuPlanResource\RelationManagers;
use App\Filament\Resources\MenuPlanResource\RelationManagers\MenuPlanItemRelationManager;
use App\Filament\Resources\MenuPlanResource\RelationManagers\MenuPlanMenuRelationManager;
use Filament\Tables\Filters\Filter;

class MenuPlanResource extends Resource
{
    protected static ?string $model = MenuPlan::class;

    protected static ?string $navigationGroup = 'Food Menu';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->columns(3)
                            ->schema([
                                DatePicker::make('plan_date')
                                    ->required()
                                    ->format('Y-m-d'),
                                Select::make('menu_time_id')
                                    ->label('Menu Time')
                                    ->options(MenuTime::all()->pluck('name', 'id')->toArray())
                                    ->required(),
                                Select::make('product_group_id')
                                    ->label('Product Group')
                                    ->options(ProductGroup::all()->pluck('name', 'id')->toArray())
                                    ->required(),
                                TextInput::make('estimate_pob')
                                    ->numeric()
                                    ->default(1000)
                                    ->required(),
                                TextInput::make('actual_pob')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                                TextInput::make('code')
                                    ->disabled()
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
                TextColumn::make('plan_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('menuTime.name')
                    ->label('Menu Time'),
                TextColumn::make('productGroup.name')
                    ->label('Product')->wrap(),
                TextColumn::make('estimate_pob'),
                TextColumn::make('actual_pob'),
                TextColumn::make('menus_count')
                    ->label('Menu count')
                    ->counts('menus')
            ])->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('menu_time_id')
                    ->label('Menu Time')
                    ->multiple()
                    ->options(fn () => MenuTime::all()->pluck('name', 'id')->toArray()),
                Tables\Filters\SelectFilter::make('product_group_id')
                    ->label('Product Group')
                    ->multiple()
                    ->options(fn () => ProductGroup::all()->pluck('name', 'id')->toArray()),
                Filter::make('plan_date')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('plan_date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('plan_date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\ReplicateAction::make()->button()->color('danger')
                //     ->form([Forms\Components\DatePicker::make('plan_date')->required()])
                //     ->beforeReplicaSaved(function (Model $replica, array $data): void {
                //         $replica->plan_date = $data['plan_date'];
                //     })
                //     ->visible(fn (MenuPlan $record) => $record->menus()->count()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MenuPlanMenuRelationManager::class,
            MenuPlanItemRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuPlans::route('/'),
            'create' => Pages\CreateMenuPlan::route('/create'),
            'edit' => Pages\EditMenuPlan::route('/{record}/edit'),
        ];
    }
}
