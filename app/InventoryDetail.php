<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryDetail extends Model
{
    protected $fillable = [
        'inventory_id',
        'product_id',
        'old_quantity',
        'new_quantity',
        'min_cost',
        'max_cost',
        'default_cost',
        'avg_cost'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
