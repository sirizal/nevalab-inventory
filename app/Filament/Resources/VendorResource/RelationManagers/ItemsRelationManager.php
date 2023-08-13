<?php

namespace App\Filament\Resources\VendorResource\RelationManagers;

use Filament\Forms;
use App\Models\Item;
use App\Models\Vendor;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'item_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->label('Item')
                    ->required()
                    ->searchable()
                    ->options(Item::all()->pluck('description', 'id')->toArray()),
                TextInput::make('price')
                    ->required()
                    ->numeric(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        if (!$state) {
                            $set('status', '0');
                        } else {
                            $set('status', '1');
                        }
                    }),
                Hidden::make('status')->default('0')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('item.description'),
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(fn (string $state): string => number_format($state, 0, '.', ',')),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum([
                        '0' => 'active',
                        '1' => 'inactive'
                    ])
                    ->colors([
                        'success' => '0',
                        'danger' => '1'
                    ]),
                Tables\Columns\TextColumn::make('start_date'),
                Tables\Columns\TextColumn::make('end_date')
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
