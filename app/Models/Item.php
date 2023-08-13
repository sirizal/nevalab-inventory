<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'description_uom',
        'specification',
        'grammage',
        'standard_cost',
        'status',
        'category_1',
        'category_2',
        'category_3',
        'item_type_id',
        'uom_id',
        'storage_type_id'
    ];

    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uom::class);
    }

    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    public function storageType(): BelongsTo
    {
        return $this->belongsTo(StorageType::class);
    }

    public function category1(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_1', 'id');
    }

    public function category2(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_2', 'id');
    }

    public function category3(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_3', 'id');
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    public function vendorItems(): HasMany
    {
        return $this->hasMany(VendorItem::class);
    }
}
