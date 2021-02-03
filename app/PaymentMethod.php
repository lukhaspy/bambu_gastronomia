<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'branch_id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function transactions(){
        return $this->hasMany('App\Transaction', 'payment_method_id', 'id');
    }
}
