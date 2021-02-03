<?php

namespace App;

use App\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Transaction extends Model{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'spendingProfile_id',
        'reference',
        'amount',
        'payment_method_id',
        'type',
        'client_id',
        'user_id',
        'sale_id',
        'receipt_id',
        'provider_id',
        'transfer_id',
        'branch_id'
    ];

    protected static function booted(){
        static::addGlobalScope(new BranchScope);
    }

    public function method(){
        return $this->belongsTo('App\PaymentMethod','payment_method_id');
    }

    public function provider(){
        return $this->belongsTo('App\Provider');
    }

    public function sale(){
        return $this->belongsTo('App\Sale');
    }

    public function receipt(){
        return $this->belongsTo('App\Receipt');
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }

    public function transfer(){
        return $this->belongsTo('App\Transfer');
    }

    public function spendingProfile(){
        return $this->belongsTo('App\SpendingProfile', 'spendingProfile_id');
    }

    public function scopeFindByPaymentMethodId($query, $id){
        return $query->where('payment_method_id', $id);
    }

    public function scopeThisMonth($query){
        return $query->whereMonth('created_at', Carbon::now()->month);
    }
}
