<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuPlanItem extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'menu_item_id', 'menu_plan_id', 'menu_plan_menu_id'];

    public function menuPlan(): BelongsTo
    {
        return $this->belongsTo(MenuPlan::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class);
    }

    public function menuPlanMenu(): BelongsTo
    {
        return $this->belongsTo(MenuPlanMenu::class);
    }
}
