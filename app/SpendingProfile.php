<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpendingProfile extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];


    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'spendingProfile_id');
    }
}
