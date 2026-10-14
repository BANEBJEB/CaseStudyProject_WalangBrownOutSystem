<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReorderPoint extends Model
{
    protected $fillable = [
        'product_id', 'min_stock', 'max_stock', 'reorder_point',
        'seasonal_multiplier', 'lead_time_days', 'last_review_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}