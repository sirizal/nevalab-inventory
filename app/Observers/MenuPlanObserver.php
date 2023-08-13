<?php

namespace App\Observers;

use App\Models\MenuPlan;

class MenuPlanObserver
{
    public function creating(MenuPlan $menuPlan): void
    {
        $prefix = 'MENUPLAN';
        $number = MenuPlan::max('id') + 1;
        $code = $prefix . '-' . str_pad($number, 5, 0, STR_PAD_LEFT);
        $menuPlan->code = $code;
    }

    /**
     * Handle the MenuPlan "created" event.
     */
    public function created(MenuPlan $menuPlan): void
    {
        //
    }

    /**
     * Handle the MenuPlan "updated" event.
     */
    public function updated(MenuPlan $menuPlan): void
    {
        //
    }

    /**
     * Handle the MenuPlan "deleted" event.
     */
    public function deleted(MenuPlan $menuPlan): void
    {
        //
    }

    /**
     * Handle the MenuPlan "restored" event.
     */
    public function restored(MenuPlan $menuPlan): void
    {
        //
    }

    /**
     * Handle the MenuPlan "force deleted" event.
     */
    public function forceDeleted(MenuPlan $menuPlan): void
    {
        //
    }
}
