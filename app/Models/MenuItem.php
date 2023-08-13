<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'item_id', 'grammage'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function menuPlanItems(): HasMany
    {
        return $this->hasMany(MenuPlanItem::class);
    }
}
