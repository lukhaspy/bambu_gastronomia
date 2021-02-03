<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model{

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'sended_amount',
        'received_amount',
        'sender_method_id',
        'receiver_method_id',
        'reference',
        'branch_id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction');
    }

    public function sender_method(){
        return $this->belongsTo('App\PaymentMethod', 'sender_method_id');
    }

    public function receiver_method(){
        return $this->belongsTo('App\PaymentMethod', 'receiver_method_id');
    }
}
