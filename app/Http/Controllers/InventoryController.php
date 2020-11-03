<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\ProductCategory;
use App\Provider;
use App\Receipt;
use App\ReceivedProduct;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function stats(Request $request)
    {
        $cmd = '';
        if ($request->filled('provider_id')) {
            $cmd = ' AND pro.id = ' . $request['provider_id'];
        }
        if ($request->filled('product_id')) {
            $cmd .= ' AND p.id = ' . $request['product_id'];
        }
        $productsProviders = Product::getProductsByProvider($cmd);
        $products = Product::where('type', '<>', 2)->get();
        $providers = Provider::all();


        return view('inventory.stats', [
            'categories' => ProductCategory::all(),
            'products' => $products,
            'providers' => $providers,
            'productsProviders' => $productsProviders,
            'soldproductsbystock' => SoldProduct::selectRaw('product_id, max(created_at), sum(qty) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')->whereYear('created_at', Carbon::now()->year)->groupBy('product_id')->orderBy('total_qty', 'desc')->limit(15)->get(),
            'soldproductsbyincomes' => SoldProduct::selectRaw('product_id, max(created_at), sum(qty) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')->whereYear('created_at', Carbon::now()->year)->groupBy('product_id')->orderBy('incomes', 'desc')->limit(15)->get(),
            'soldproductsbyavgprice' => SoldProduct::selectRaw('product_id, max(created_at), sum(qty) as total_qty, sum(total_amount) as incomes, avg(price) as avg_price')->whereYear('created_at', Carbon::now()->year)->groupBy('product_id')->orderBy('avg_price', 'desc')->limit(15)->get()
        ]);
    }
}
