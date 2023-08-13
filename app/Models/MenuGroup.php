<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuGroup extends Model
{
    use HasFactory;

    protected $fillable = ['product_group_id', 'menu_time_id', 'code', 'name', 'image'];

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function menuTime(): BelongsTo
    {
        return $this->belongsTo(MenuTime::class);
    }

    public function menuGroupMenus(): HasMany
    {
        return $this->hasMany(MenuGroupMenu::class);
    }
}
