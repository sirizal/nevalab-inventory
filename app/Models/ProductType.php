<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'jjt', 'client_id'];

    public function productGroup(): HasMany
    {
        return $this->hasMany(ProductGroup::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(client::class);
    }
}
