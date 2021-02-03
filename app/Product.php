<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
        'branch_id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

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

    public static function getProductsByProvider($cmd = ''){

        return DB::select(DB::raw(
            "SELECT p.*,
             avg(rp.cost) as cost,
             min(rp.cost) as costMin,
             max(rp.cost) as costMax,
             p.unity,
             c.name as category,
             pro.name as provider
            from products p
            inner join product_categories c on p.product_category_id = c.id
            inner join received_products rp on p.id = rp.product_id
            inner join receipts r on rp.receipt_id = r.id
            inner join providers pro on r.provider_id = pro.id
            Where 1=1 $cmd
            group by  rp.product_id, r.provider_id
            order by cost asc"
        ));
    }
}
