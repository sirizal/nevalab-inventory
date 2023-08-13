<?php

namespace App\Filament\Resources;

use App\Models\Uom;
use Filament\Forms;
use App\Models\Item;
use Filament\Tables;
use App\Models\Category;
use App\Models\ItemType;
use App\Models\StorageType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ItemResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ItemResource\RelationManagers;
use Filament\Tables\Columns\BadgeColumn;
use Spatie\FlareClient\Http\Exceptions\BadResponse;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationGroup = 'Item';

    protected static ?string $navigationIcon = 'heroicon-o-view-boards';

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
                                Select::make('item_type_id')
                                    ->label('Item Type')
                                    ->searchable()
                                    ->options(ItemType::all()->pluck('name', 'id')->toArray())
                                    ->required(),
                                Select::make('storage_type_id')
                                    ->label('Storage Type')
                                    ->searchable()
                                    ->options(StorageType::all()->pluck('name', 'id')->toArray()),
                                TextInput::make('code')
                                    ->label('Item Code')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Item::class, column: 'code', ignoreRecord: true),
                                TextInput::make('description')
                                    ->required()
                                    ->columnSpan(3),
                                TextInput::make('specification')
                                    ->columnSpan(3),
                                Select::make('uom_id')
                                    ->label('UOM')
                                    ->searchable()
                                    ->options(Uom::all()->pluck('code', 'id')->toArray())
                                    ->required(),
                                TextInput::make('description_uom')
                                    ->label('Deskripsi UOM'),
                                TextInput::make('grammage')
                                    ->label('Grammage')
                                    ->numeric()
                                    ->required(),
                                Select::make('category_1')
                                    ->label('Category 1')
                                    ->searchable()
                                    ->options(Category::whereNull('parent_id')->pluck('name', 'id')->toArray())
                                    ->reactive()
                                    ->afterStateUpdated(
                                        function (callable $set) {
                                            $set('category_2', null);
                                            $set('category_3', null);
                                        }
                                    )
                                    ->required(),
                                Select::make('category_2')
                                    ->label('Category 2')
                                    ->searchable()
                                    ->options(function ($get) {
                                        $category1 = $get('category_1');

                                        if ($category1) {
                                            return Category::where('parent_id', $category1)
                                                ->get()
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        }
                                    })
                                    ->reactive()
                                    ->afterStateUpdated(
                                        fn (callable $set) => $set('category_3', null)
                                    )
                                    ->required(),
                                Select::make('category_3')
                                    ->label('Category 3')
                                    ->searchable()
                                    ->options(function ($get) {
                                        $category2 = $get('category_2');

                                        if ($category2) {
                                            return Category::where('parent_id', $category2)
                                                ->get()
                                                ->pluck('name', 'id')
                                                ->toArray();
                                        }
                                    })
                                    ->reactive()
                                    ->required(),
                                TextInput::make('standard_cost')
                                    ->label('Standard Cost')
                                    ->numeric()
                                    ->required(),
                                Toggle::make('status')
                                    ->label('Active')
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                TextColumn::make('uom.code'),
                TextColumn::make('category1.name')
                    ->label('Category1')
                    ->wrap(),
                TextColumn::make('category2.name')
                    ->label('Category2')
                    ->wrap(),
                TextColumn::make('category3.name')
                    ->label('Category3')
                    ->wrap(),
                TextColumn::make('storageType.name')
                    ->label('Storage Type')
                    ->wrap(),
                BadgeColumn::make('status')
                    ->enum([
                        0 => 'active',
                        1 => 'blocked'
                    ])
                    ->colors([
                        'success' => 0,
                        'danger' => 1
                    ]),
                TextColumn::make('grammage')
                    ->formatStateUsing(fn (string $state): string => number_format($state, 0, '.', ',')),
                TextColumn::make('standard_cost')
                    ->formatStateUsing(fn (string $state): string => number_format($state, 0, '.', ',')),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
