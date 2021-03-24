<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Sale;
use Illuminate\Http\Request;

class SaleApiController extends Controller
{
    protected $sale;
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function getOrders()
    {
        $sales = $this->sale->where(function ($q) {
            $q->where('preparing_at', '<>', NULL)
                ->where('prepared_at', NULL);
        })->with(['products.product', 'client', 'user'])->get();

        return response()->json(['sales' => $sales]);
    }
}
