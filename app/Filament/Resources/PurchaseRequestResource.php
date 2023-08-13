<?php

namespace App\Filament\Resources;

use App\Models\Uom;
use Filament\Forms;
use App\Models\Site;
use Filament\Tables;
use App\Models\Vendor;
use App\Models\Warehouse;
use App\Models\VendorItem;
use App\Models\ProductType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\PurchaseRequest;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PurchaseRequestResource\Pages;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use App\Filament\Resources\PurchaseRequestResource\RelationManagers;
use App\Filament\Resources\PurchaseRequestResource\RelationManagers\ItemsRelationManager;
use App\Models\User;
use Filament\Forms\Components\FileUpload;

class PurchaseRequestResource extends Resource
{
    protected static ?string $model = PurchaseRequest::class;

    protected static ?string $navigationGroup = 'Purchase';

    protected static ?string $recordTitleAttribute = 'code';

    protected static ?string $navigationLabel = 'All PRA';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('heading')
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Header')
                            ->schema([
                                Grid::make()
                                    ->columns(3)
                                    ->schema([
                                        Select::make('vendor_id')
                                            ->label('Supplier')
                                            ->options(Vendor::all()->pluck('name', 'id')->toArray())
                                            ->required()
                                            ->reactive(),
                                        DatePicker::make('request_delivery_date')
                                            ->label('Delivery Request')
                                            ->required(),
                                        DatePicker::make('request_receive_date')
                                            ->label('Receive Request')
                                            ->required(),
                                        Select::make('product_type_id')
                                            ->label('Product Type')
                                            ->options(ProductType::all()->pluck('name', 'id')->toArray()),
                                        Select::make('site_id')
                                            ->label('Site')
                                            ->reactive()
                                            ->options(Site::all()->pluck('name', 'id')->toArray()),
                                        Select::make('purchase_type')
                                            ->label('Purchase Type')
                                            ->options([
                                                'item' => 'item',
                                                'gl' => 'gl'
                                            ])
                                            ->reactive()
                                            ->default('item')
                                            ->disabled(fn ($livewire) => $livewire instanceof EditRecord),
                                        TextInput::make('purchase_no')
                                            ->label('PO No')
                                            ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
                                        DatePicker::make('purchase_date')
                                            ->label('PO date')
                                            ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
                                        Select::make('purchase_user')
                                            ->label('Creator PO')
                                            ->options(User::all()->pluck('name', 'id')->toArray())
                                            ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
                                        FileUpload::make('purchase_no_file')
                                            ->label('Document PO')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
                                        TextInput::make('remarks')
                                            ->label('Remark')
                                    ])
                            ]),
                        Tabs\Tab::make('Items')
                            ->schema([
                                TableRepeater::make('purchaseRequestItems')
                                    ->breakPoint('sm')
                                    ->disableLabel()
                                    ->relationship()
                                    ->headers(['Warehouse', 'Item', 'GL No', 'Description', 'Req Qty', 'UOM', 'Price', 'Job No', 'Task No', 'VAT'])
                                    ->columnWidths([
                                        'warehouse_id' => '180px',
                                        'request_qty' => '120px',
                                        'uom_id' => '100px',
                                        'price' => '120px',
                                        'job_no' => '100px',
                                        'task_no' => '100px',
                                        'vat' => '120px'
                                    ])
                                    ->schema([
                                        Select::make('warehouse_id')
                                            ->disableLabel()
                                            ->options(fn ($get) => Warehouse::where('site_id', $get('../../site_id'))->get()->pluck('code', 'id')->toArray()),
                                        Select::make('item_id')
                                            ->disableLabel()
                                            ->reactive()
                                            ->searchable()
                                            ->options(fn ($get) => VendorItem::where('vendor_id', $get('../../vendor_id'))->where('status', 0)->get()->pluck('item.description', 'item_id')->toArray())
                                            ->hidden(fn ($get) => $get('../../purchase_type') == 'gl')
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                $vendorItem = VendorItem::where('item_id', $state)
                                                    ->where('status', 0)
                                                    ->where('vendor_id', $get('../../vendor_id'))
                                                    ->first();
                                                $set('price', (string)($vendorItem->price));
                                                $set('description', (string)($vendorItem->item->description));
                                                $set('uom_id', (string)($vendorItem->item->uom_id));
                                            }),
                                        TextInput::make('gl_no')
                                            ->disableLabel()
                                            ->visible(fn ($get) => $get('../../purchase_type') == 'gl'),
                                        TextInput::make('description')
                                            ->disableLabel()
                                            ->visible(fn ($get) => $get('../../purchase_type') == 'gl'),
                                        TextInput::make('request_qty')
                                            ->numeric()
                                            ->disableLabel(),
                                        Select::make('uom_id')
                                            ->disableLabel()
                                            ->options(Uom::query()->pluck('code', 'id')->toArray()),
                                        TextInput::make('price')
                                            ->disableLabel()
                                            ->disabled(fn ($get) => $get('../../purchase_type') == 'item'),
                                        TextInput::make('job_no')
                                            ->disableLabel()
                                            ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
                                        TextInput::make('task_no')
                                            ->disableLabel()
                                            ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
                                        TextInput::make('vat')
                                            ->numeric()
                                            ->disableLabel()
                                            ->hidden(fn ($livewire) => $livewire instanceof CreateRecord),
                                        Hidden::make('description')
                                    ])
                                    ->columnSpan('full')
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('code')->label('PRA No')->sortable(),
                TextColumn::make('request_date')->date(),
                TextColumn::make('vendor.name')->label('Vendor')->wrap(),
                TextColumn::make('purchase_no')->label('PO No'),
                TextColumn::make('purchase_date')->date(),
                TextColumn::make('request_delivery_date')->date()->label('Req Delivery'),
                TextColumn::make('request_receive_date')->date()->label('Req Receive')
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
            //ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseRequests::route('/'),
            'create' => Pages\CreatePurchaseRequest::route('/create'),
            'edit' => Pages\EditPurchaseRequest::route('/{record}/edit'),
        ];
    }
}
