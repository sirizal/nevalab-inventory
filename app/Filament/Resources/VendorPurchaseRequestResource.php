<?php

namespace App\Filament\Resources;

use Closure;
use App\Models\Uom;
use Filament\Forms;
use App\Models\Item;
use App\Models\Site;
use Filament\Tables;
use App\Models\Vendor;
use App\Models\Warehouse;
use App\Models\VendorItem;
use App\Models\ProductType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use App\Models\PurchaseRequest;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
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
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use App\Filament\Resources\VendorPurchaseRequestResource\Pages;

class VendorPurchaseRequestResource extends Resource
{
    protected static ?string $model = PurchaseRequest::class;

    protected static ?string $navigationGroup = 'Purchase';

    protected static ?string $recordTitleAttribute = 'code';

    protected static ?string $navigationLabel = 'Supplier PRA';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $slug = 'vendor-pra';

    protected static ?int $navigationSort = 1;


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
                                            ->disabled()
                                            ->options(Vendor::all()->pluck('name', 'id')->toArray())
                                            ->required()
                                            ->reactive(),
                                        DatePicker::make('request_delivery_date')
                                            ->disabled()
                                            ->label('Delivery Request')
                                            ->required(),
                                        DatePicker::make('request_receive_date')
                                            ->disabled()
                                            ->label('Receive Request')
                                            ->required(),
                                        Select::make('product_type_id')
                                            ->disabled()
                                            ->label('Product Type')
                                            ->options(ProductType::all()->pluck('name', 'id')->toArray()),
                                        Select::make('site_id')
                                            ->disabled()
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
                                            ->disabled(fn ($livewire) => $livewire instanceof EditRecord),
                                        DatePicker::make('purchase_date')
                                            ->label('PO date')
                                            ->disabled(fn ($livewire) => $livewire instanceof EditRecord),
                                        TextInput::make('delivery_no')
                                            ->label('No Surat Jalan')
                                            ->required(),
                                        DatePicker::make('delivery_date')
                                            ->label('Tanggal Kirim')
                                            ->reactive()
                                            ->required(),
                                        TextInput::make('vehicle_no')
                                            ->label('No Mobil')
                                            ->required(),
                                        TextInput::make('driver_name')
                                            ->label('Nama Sopir')
                                            ->required(),
                                        TextInput::make('driver_ktp')
                                            ->label('No KTP Sopir')
                                            ->required(),
                                        TextInput::make('driver_phone_no')
                                            ->label('No HP Sopir')
                                            ->required(),
                                        TextInput::make('delivery_by')
                                            ->label('Dikirim pake')
                                            ->required(),
                                    ])
                            ]),
                        Tabs\Tab::make('Items')
                            ->schema([
                                Repeater::make('purchaseRequestItems')
                                    ->relationship()
                                    ->columns(3)
                                    ->disableLabel()
                                    ->schema([
                                        Select::make('warehouse_id')
                                            ->label('Gudang')
                                            ->disabled()
                                            ->options(fn ($get) => Warehouse::where('site_id', $get('../../site_id'))->get()->pluck('code', 'id')->toArray()),
                                        Select::make('item_id')
                                            ->label('Item')
                                            ->disabled()
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
                                            ->label('GL No')
                                            ->disabled()
                                            ->visible(fn ($get) => $get('../../purchase_type') == 'gl'),
                                        TextInput::make('description')
                                            ->visible(fn ($get) => $get('../../purchase_type') == 'gl'),
                                        TextInput::make('request_qty')
                                            ->numeric()
                                            ->disabled(),
                                        Select::make('uom_id')
                                            ->label('Satuan')
                                            ->disabled()
                                            ->options(Uom::query()->pluck('code', 'id')->toArray()),
                                        TextInput::make('price')
                                            ->disabled(fn ($get) => $get('../../purchase_type') == 'item'),
                                        TextInput::make('toreceive_qty')
                                            ->label('Delivery Qty')
                                            ->numeric()
                                            ->maxValue(fn ($get) => $get('request_qty')),
                                        Hidden::make('description'),
                                        DatePicker::make('production_date')
                                            ->label('Tanggal Produksi')
                                            ->minDate(function (Closure $get) {
                                                $deliveryDate = $get('../../delivery_date');
                                                $storage_type = $get('storage_type');
                                                if ($deliveryDate != null) {
                                                    if ($storage_type == 'Frozen Storage') {
                                                        return Carbon::parse($deliveryDate)->subDays(14);
                                                    } elseif ($storage_type == 'Dry Storage') {
                                                        return Carbon::parse($deliveryDate)->subDays(30);
                                                    } else {
                                                        return Carbon::parse($deliveryDate)->subDays(3);
                                                    }
                                                }
                                                return null;
                                            })
                                            ->maxDate(function (Closure $get) {
                                                $deliveryDate = $get('../../delivery_date');
                                                if ($deliveryDate != null) {
                                                    return Carbon::parse($deliveryDate);
                                                }
                                                return null;
                                            })
                                            ->closeOnDateSelection()
                                            ->required(),
                                        DatePicker::make('expire_date')
                                            ->label('Tanggal Expire')
                                            ->minDate(function (Closure $get) {
                                                $deliveryDate = $get('../../delivery_date');
                                                $storage_type = $get('storage_type');
                                                if ($deliveryDate != null) {
                                                    if ($storage_type == 'Frozen Storage') {
                                                        return Carbon::parse($deliveryDate)->addDays(60);
                                                    } elseif ($storage_type == 'Dry Storage') {
                                                        return Carbon::parse($deliveryDate)->addDays(365);
                                                    } else {
                                                        return Carbon::parse($deliveryDate)->addDays(3);
                                                    }
                                                }
                                                return null;
                                            })
                                            ->closeOnDateSelection()
                                            ->required(),
                                        FileUpload::make('doc_no')
                                            ->label('Dokumen Teknis (pdf)')
                                            ->preserveFilenames()
                                            ->enableDownload()
                                            ->acceptedFileTypes(['application/pdf']),
                                        TextInput::make('packing_description')
                                            ->label('Kemasan/Packing'),
                                        Placeholder::make('sps')
                                            ->content(new HtmlString('<a href="https://filamentphp.com/docs">filamentphp.com</a>')),
                                        TextInput::make('storage_type')
                                            ->label('Tipe Penyimpanan')
                                            ->disabled()
                                            ->afterStateHydrated(function ($get, TextInput $component) {
                                                $item = Item::where('id', $get('item_id'))->first();
                                                $component->state($item->storageType->name);
                                            })
                                            ->dehydrated(false),
                                        TextInput::make('reason_not_deliver')
                                            ->label('Alasan tidak bisa kirim')
                                            ->required(fn ($get) => $get('toreceive_qty') == 0)
                                    ])
                                    ->columnSpan('full')
                                    ->disableItemCreation()
                                    ->disableItemDeletion()
                                    ->disableItemMovement()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendorPurchaseRequests::route('/'),
            'create' => Pages\CreateVendorPurchaseRequest::route('/create'),
            'edit' => Pages\EditVendorPurchaseRequest::route('/{record}/edit'),
        ];
    }
}
