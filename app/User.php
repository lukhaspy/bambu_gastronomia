<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable{

    use SoftDeletes, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'default_branch',
        'branch_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function branches(){
		return $this->belongsToMany('App\Branch', 'user_branches');
	}

}
