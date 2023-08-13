<?php

namespace App\Observers;

use App\Models\MenuItem;
use App\Models\MenuPlanItem;
use App\Models\MenuPlanMenu;

class MenuPlanMenuObserver
{
    /**
     * Handle the MenuPlanMenu "created" event.
     */
    public function created(MenuPlanMenu $menuPlanMenu): void
    {
        $menuItems = MenuItem::where('menu_id', $menuPlanMenu->menu_id)->get();

        foreach ($menuItems as $menuItem) {
            MenuPlanItem::create([
                'menu_plan_id' => $menuPlanMenu->menu_plan_id,
                'menu_id' => $menuPlanMenu->menu_id,
                'menu_item_id' => $menuItem->id,
                'menu_plan_menu_id' => $menuPlanMenu->id
            ]);
        }
    }

    /**
     * Handle the MenuPlanMenu "updated" event.
     */
    public function updated(MenuPlanMenu $menuPlanMenu): void
    {
        //
    }

    /**
     * Handle the MenuPlanMenu "deleted" event.
     */
    public function deleting(MenuPlanMenu $menuPlanMenu): void
    {
        $menuPlanMenu->items->each->delete();
    }

    /**
     * Handle the MenuPlanMenu "deleted" event.
     */
    public function deleted(MenuPlanMenu $menuPlanMenu): void
    {
        //$menuPlanMenu->items->each->delete();
    }

    /**
     * Handle the MenuPlanMenu "restored" event.
     */
    public function restored(MenuPlanMenu $menuPlanMenu): void
    {
        //
    }

    /**
     * Handle the MenuPlanMenu "force deleted" event.
     */
    public function forceDeleted(MenuPlanMenu $menuPlanMenu): void
    {
        //
    }
}
