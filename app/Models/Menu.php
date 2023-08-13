<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_type_id', 'name', 'grammage'];

    public function menuType(): BelongsTo
    {
        return $this->belongsTo(MenuType::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }
}
