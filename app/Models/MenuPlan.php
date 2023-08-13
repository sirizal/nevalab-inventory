<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class MenuPlan extends Model
{
    use HasFactory;

    protected $fillable = ['plan_date', 'code', 'estimate_pob', 'actual_pob', 'menu_time_id', 'product_group_id'];

    public function menuTime(): BelongsTo
    {
        return $this->belongsTo(MenuTime::class);
    }

    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(MenuPlanMenu::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuPlanItem::class);
    }

    public function storeRequests(): HasMany
    {
        return $this->hasMany(StoreRequest::class);
    }

    public function replicateRow()
    {
        $clone = $this->replicate();
        $clone->push();

        foreach ($this->menus as $menu) {
            $clone->menus()->create($menu->toArray());
        }

        // foreach ($this->items as $item) {
        //     $clone->items()->create($item->toArray());
        // }

        $clone->save();
    }

    public function createStoreRequest()
    {
        $store_request = StoreRequest::create([
            'code' => make_store_request_no(),
            'request_delivery_date' => Carbon::parse($this->plan_date)->subDays(3),
            'product_type_id' => $this->productGroup->productType->id,
            'site_id' => $this->productGroup->site->id,
            'menu_plan_id' => $this->id,
            'user_id' => Auth::user()->id,
            'remarks' => 'Store Request Created From ' . $this->code
        ]);


        foreach ($this->items as $item) {
            StoreRequestItem::create([
                'store_request_id' => $store_request->id,
                'menu_plan_item_id' => $item->id,
                'item_id' => $item->menuItem->item->id,
                'description' => $item->menuItem->item->description,
                'uom_id' => $item->menuItem->item->uom->id,
                'request_qty' => (($item->menuItem->grammage * $item->menuPlan->estimate_pob) / $item->menuItem->item->grammage)
            ]);
        }
    }
}
