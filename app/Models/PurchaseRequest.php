<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function createUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user', 'id');
    }

    public function modifyUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modify_user', 'id');
    }

    public function purchaseUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchase_user', 'id');
    }

    public function deliveryUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delivery_user', 'id');
    }

    public function inspectionUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspection_user', 'id');
    }

    public function receiveUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receive_user', 'id');
    }

    public function erpReceiveUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'erp_receive_user', 'id');
    }

    public function returnUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'return_user', 'id');
    }

    public function vendorInvoiceUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_invoice_user', 'id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    function purchaseRequestItems(): HasMany
    {
        return $this->hasMany(PurchaseRequestItem::class);
    }
}
