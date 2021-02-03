<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model{

    use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = ['name', 'branch_id'];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function products(){
        return $this->hasMany('App\Product');
    }
}
