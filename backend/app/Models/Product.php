<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku', 'product_name', 'category', 'sub_category',
        'unit_price', 'weight_kg', 'shelf_life_months', 'seasonality',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function reorderPoint()
    {
        return $this->hasOne(ReorderPoint::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function getTotalAvailableAttribute()
    {
        return $this->inventory()->sum('quantity');
    }
}