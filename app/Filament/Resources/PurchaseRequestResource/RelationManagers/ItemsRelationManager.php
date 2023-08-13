<?php

namespace App\Filament\Resources\PurchaseRequestResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Warehouse;
use App\Models\VendorItem;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'purchaseRequestItems';

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->columns(3)
                            ->schema([
                                Select::make('warehouse_id')
                                    ->required()
                                    ->label('Warehouse')
                                    ->options(function (RelationManager $livewire) {
                                        return Warehouse::where('site_id', $livewire->ownerRecord->site_id)
                                            ->get()
                                            ->pluck('code', 'id')
                                            ->toArray();
                                    }),
                                Select::make('item_id')
                                    ->required()
                                    ->label('Item')
                                    ->searchable()
                                    ->options(function (RelationManager $livewire) {
                                        return VendorItem::where('vendor_id', $livewire->ownerRecord->vendor_id)
                                            ->where('status', 0)
                                            ->get()
                                            ->pluck('item.description', 'item_id')
                                            ->toArray();
                                    })
                                    ->hidden(fn (RelationManager $livewire) => $livewire->ownerRecord->purchase_type == 'gl'),
                                TextInput::make('gl_no')
                                    ->label('GL No')
                                    ->hidden(fn (RelationManager $livewire) => $livewire->ownerRecord->purchase_type == 'item')
                            ])
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('purchase_request_id'),
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
