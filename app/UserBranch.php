<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBranch extends Model{

    protected $fillable = [
        'user_id',
        'branch_id'
    ];

}
