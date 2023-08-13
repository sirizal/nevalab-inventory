<?php

namespace App\Filament\Resources\StoreRequestResource\RelationManagers;

use App\Models\Item;
use App\Models\Uom;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoreRequestItemRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'items';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->label('Item')
                    ->searchable()
                    ->options(Item::all()->pluck('description', 'id')->toArray())
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $request_item = Item::where('id', $state)->first();

                        //dd($request_item['description']);
                        $set('description', (string)$request_item['description']);
                        $set('uom_id', $request_item['uom_id']);
                    }),
                Forms\Components\TextInput::make('description')
                    ->required(),
                Forms\Components\Select::make('uom_id')
                    ->label('UOM')
                    ->searchable()
                    ->options(Uom::query()->pluck('code', 'id')->toArray()),
                Forms\Components\TextInput::make('request_qty')
                    ->numeric()
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item.code')
                    ->label('Kode Item'),
                Tables\Columns\TextColumn::make('description')
                    ->wrap(),
                Tables\Columns\TextColumn::make('uom.code')
                    ->label('Uom'),
                Tables\Columns\TextColumn::make('request_qty')
                    ->label('Req Qty')
                    ->formatStateUsing(fn (string $state): string => number_format($state, 0, '.', ','))
            ])
            ->filters([
                //
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
