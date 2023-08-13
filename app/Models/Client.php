<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'country', 'province', 'city', 'phone'];

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function productTypes(): HasMany
    {
        return $this->hasMany(ProductType::class);
    }
}
