<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedProduct extends Model{

    use SoftDeletes;

    protected $fillable = [
        'receipt_id',
        'product_id',
        'qty',
        'cost',
        'total_amount'
    ];

    public function receipt(){
        return $this->belongsTo('App\Receipt');
    }

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
