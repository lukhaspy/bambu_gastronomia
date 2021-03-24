<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\BranchScope;

class Inventory extends Model
{
    protected $fillable = ['user_id', 'observations'];
    use SoftDeletes;


    protected static function booted()
    {
        static::addGlobalScope(new BranchScope);
    }

    public function details()
    {
        return $this->hasMany(InventoryDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
