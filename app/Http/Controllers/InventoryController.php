<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\ProductCategory;
use App\Provider;
use App\Receipt;
use App\ReceivedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    private $inventory, $product;
    public function __construct(Inventory $inventory, Product $product)
    {
        $this->inventory = $inventory;
        $this->product = $product;
    }


    public function index()
    {
        $inventories = $this->inventory->with(['details' => function ($q) {

            $q->selectRaw('
            inventory_id,
           if(new_quantity > old_quantity,
           min_cost * (new_quantity - old_quantity),
           min_cost * (old_quantity - new_quantity) * -1)   as sumMin,

           if(new_quantity > old_quantity,
           max_cost * (new_quantity - old_quantity),
           max_cost * (old_quantity - new_quantity) * -1)   as sumMax,

           if(new_quantity > old_quantity,
           avg_cost * (new_quantity - old_quantity),
           avg_cost * (old_quantity - new_quantity) * -1)   as sumAvg
            ');
        }])->orderBy('id', 'desc')->limit(30)->paginate(10);

        return view('inventory.inventory.index', compact('inventories'));
    }


    public function create()
    {
        $lastInventory = $this->inventory->latest()->first();
        $products = $this->product->lastPurchases($lastInventory);

        return view('inventory.inventory.create', compact('products'));
    }
    public function search(Request $request)
    {
        $filters = $request->all();
        $inventories = $this->inventory->where(function ($q) use ($request) {
            if ($request->filled('desde') && $request->filled('hasta')) {
                $q->whereBetween('created_at', [$request['desde'], $request['hasta']]);
            }
        })->orderBy('id', 'desc')->paginate(10);


        return view('inventory.inventory.index', compact('inventories', 'filters'));
    }
    public function show($id)
    {
        if (!$inventory = $this->inventory->find($id)) {
            return redirect()->back();
        }
        return view('inventory.inventory.show', compact('inventory'));
    }
    public function store(Request $request)
    {
        $request->merge(['branch_id' => session('dBranch'), 'user_id' => auth()->user()->id]);


        $products = $request['products'];

        DB::beginTransaction();

        $lastInventory = $this->inventory->latest()->first();
        $inventory = $this->inventory->create($request->all());
        $inventory->details()->createMany($products);


        $detailsInventory = $inventory->details()->with(['product.receiveds' => function ($q) use ($lastInventory) {
            $q->select('product_id')
                ->selectRaw('avg(cost) as avg, 
                max(cost) as max, 
                min(cost) as min');

            // Solo verifica por la fecha entre inventarios si existe inventario anterior
            if ($lastInventory) {
                $q->whereBetween('created_at', [
                    $lastInventory->created_at->format('Y-m-d'),
                    now()->addDay(1)->format('Y-m-d')
                ]);
            }
            $q->groupBy('product_id');
        }])->get();


        $detailsInventory->each(function ($detail) {
            $detail->product->update(['stock' => $detail->new_quantity]);
            $detail->product->receiveds->each(function ($receive) use ($detail) {
                $detail->update([
                    'min_cost' => $receive->min,
                    'max_cost' => $receive->max,
                    'avg_cost' => $receive->avg
                ]);
            });
        });




        DB::commit();


        return redirect()->route('inventory.inventory.index')->withStatus('Inventario agregado correctamente.');
    }
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
