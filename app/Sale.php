<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'client_id', 'user_id', 'date'
    ];
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
    public function products()
    {
        return $this->hasMany('App\SoldProduct');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
