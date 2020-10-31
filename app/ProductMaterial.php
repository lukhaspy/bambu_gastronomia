<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMaterial extends Model{

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
