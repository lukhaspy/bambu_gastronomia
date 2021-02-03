<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionType extends Model{

    use SoftDeletes;

    protected $fillable = ['type', 'description'];

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
