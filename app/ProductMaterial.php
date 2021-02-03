<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductMaterial extends Model{

    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'material_id',
        'quantity',
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function material(){
        return $this->belongsTo('App\Product', 'material_id');
    }
}
