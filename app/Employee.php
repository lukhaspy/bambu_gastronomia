<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model{

    use SoftDeletes;

    protected $fillable = [
        'document_id',
        'name',
        'surname',
        'address',
        'birth',
        'genre',
        'phone',
        'salary',
        'branch_id',
    ];

    protected $guarded = [
        'id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

}
