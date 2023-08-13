<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreRequestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_request_id',
        'menu_plan_item_id',
        'item_id',
        'description',
        'uom_id',
        'request_qty',
        'reserved_qty',
        'delivery_qty',
        'received_qty',
        'usage_qty',
        'return_qty'
    ];

    public function storeRequest(): BelongsTo
    {
        return $this->belongsTo(StoreRequest::class);
    }

    public function menuPlanItem(): BelongsTo
    {
        return $this->belongsTo(MenuPlanItem::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function uom(): BelongsTo
    {
        return $this->belongsTo(Uom::class);
    }
}
