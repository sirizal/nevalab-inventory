<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'request_delivery_date',
        'product_type_id',
        'site_id',
        'menu_plan_id',
        'user_id',
        'status',
        'remarks'
    ];

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function menuPlan(): BelongsTo
    {
        return $this->belongsTo(MenuPlan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(StoreRequestItem::class);
    }
}
