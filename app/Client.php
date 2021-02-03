<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model{

    use SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'document_id',
        'ruc',
        'birth',
        'genre',
        'address',
        'branch_id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function sales(){
        return $this->hasMany('App\Sale');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
