<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BranchScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('branch_id', session('dBranch'));
    }
}
