<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpendingProfile extends Model{

    use SoftDeletes;


    protected $guarded = ['id'];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function transactions(){
        return $this->hasMany('App\Transaction', 'spendingProfile_id');
    }
}
