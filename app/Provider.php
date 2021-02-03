<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'razon',
        'ruc',
        'email',
        'obs',
        'phone',
        'address',
        'branch_id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }

    public function receipts(){
        return $this->hasMany('App\Receipt');
    }
}
