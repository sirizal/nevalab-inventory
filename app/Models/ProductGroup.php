<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'product_type_id', 'site_id', 'price_per_pob'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function menuGroups(): HasMany
    {
        return $this->hasMany(MenuGroup::class);
    }
}
