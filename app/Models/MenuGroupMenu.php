<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuGroupMenu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'menu_group_id'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function groupMenu(): BelongsTo
    {
        return $this->belongsTo(MenuGroup::class);
    }
}
