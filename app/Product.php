<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'product_category_id',
        'price',
        'stock',
        'reserved_stock',
        'type',
        'unity',
    ];

    public function category(){
        return $this->belongsTo('App\ProductCategory', 'product_category_id')->withTrashed();
    }

    public function solds(){
        return $this->hasMany('App\SoldProduct');
    }

    public function receiveds(){
        return $this->hasMany('App\ReceivedProduct');
    }

    public function materials(){
        return $this->hasMany('App\ProductMaterial');
    }
}
