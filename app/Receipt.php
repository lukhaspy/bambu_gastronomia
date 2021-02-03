<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'provider_id',
        'user_id',
        'date',
        'branch_id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function provider(){
        return $this->belongsTo('App\Provider');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function products(){
        return $this->hasMany('App\ReceivedProduct');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
