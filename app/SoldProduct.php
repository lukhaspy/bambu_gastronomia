<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoldProduct extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'sale_id',
        'product_id',
        'price',
        'qty',
        'total_amount',
    ];



    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }
}
