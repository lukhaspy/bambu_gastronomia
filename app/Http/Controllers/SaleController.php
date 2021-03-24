<?php

namespace App\Http\Controllers;

use App\Client;
use App\Sale;
use App\Product;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use Barryvdh\DomPDF\Facade as PDF;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $sales = Sale::latest();
        $clients = Client::all();

        if ($request->filled('desde') && $request->filled('hasta')) {
            $sales->whereBetween('date', [$request['desde'], $request['hasta']]);
        }
        if ($request->filled('cliente') && !$request->filled('todos_clientes')) {
            $sales->where('client_id', $request['cliente']);
        }
        if ($request->filled('orden')) {
            switch ($request['orden']) {
                case 'fecha_asc':
                    $sales->orderBy('date', 'asc');
                    break;
                case 'fecha_desc':
                    $sales->orderBy('date', 'desc');
                    break;
            }
        }



        $sales = $sales->paginate(10);
        return view('sales.index', compact('sales', 'clients'));
    }



    public function orderIndex(Request $request)
    {


        $sales = Sale::where(function ($q) {
            $q->where('preparing_at', '<>', NULL)
                ->where('prepared_at', NULL);
        })->get();





        return view('sales.orders.index', compact('sales'));
    }


    public function orderPrepare(Sale $sale)
    {
        if (!Sale::find($sale->id)) {
            return back();
        }

        if ($sale->finalized_at || $sale->preparing_at) {
            return back()->withStatus('La venta ya fue procesada o ya esta en preparacion');
        }

        $sale->preparing_at = Carbon::now()->toDateTimeString();
        $sale->save();

        return back()->withStatus('Pedido en estado de preparo.');
    }

    public function orderPrepared(Sale $sale)
    {
        if (!Sale::find($sale->id)) {
            return back();
        }

        if ($sale->finalized_at || !$sale->preparing_at) {
            return back()->withStatus('El pedido debe estar en estado de preparo y no finalizado');
        }

        $sale->prepared_at = Carbon::now()->toDateTimeString();
        $sale->save();

        return back()->withStatus('Pedido preparado!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $products = Product::where('type', '<>', 1)->get();
        return view('sales.create', compact('clients', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request, Sale $model)
    {


        $request->merge(['branch_id' => session('dBranch')]);

        $input = $request->all();
        $products = [];
        if (isset($input['products'])) {
            $products = $input['products'];
            unset($input['products']);
        }

        foreach ($products as $key => $value) {
            $products[$key]['total_amount'] = $value['qty'] * $value['price'];
        }


        // $existent = Sale::where('client_id', $request->get('client_id'))->where('finalized_at', null)->get();

        /* if ($existent->count()) {
            return back()->withError('Existe una operación en abierto con el cliente seleccionado. <a href="' . route('sales.show', $existent->first()) . '"> Abrir Venta</a>');
        }*/

        $sale = $model->create($request->all());
        $sale->products()->createMany($products);


        return redirect()
            ->route('sales.show', ['sale' => $sale->id])
            ->withStatus('La venta ha sido registrada, pudes empezar a agregar productos y transacciones.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        if (!$sale->finalized_at) {

            $sale->products()->delete();
            $sale->transactions()->delete();
            $sale->delete();

            return redirect()
                ->route('sales.index')
                ->withStatus('Venta eliminada.');
        } else {
            return redirect()
                ->route('sales.index')
                ->withErrors('La venta no puede ser eliminada, ya esta finalizada.');
        }
    }

    public function finalize(Sale $sale)
    {
        if (!($sale->transactions->sum('amount') >= $sale->products()->sum('total_amount'))) {
            return back()->withStatus('Las transacciones no coinciden con el valor de los productos');
        }
        $sale->total_amount =  $sale->transactions->sum('amount');

        foreach ($sale->products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->stock;
            if ($sold_product->qty > $product_stock) return back()->withError("El producto '$product_name' no tiene stock suficiente. Stock: $product_stock unidades.");
        }

        foreach ($sale->products as $sold_product) {
            $sold_product->product->stock -= $sold_product->qty;
            $sold_product->product->save();
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();
        $sale->client->balance -= $sale->total_amount;
        $sale->save();
        $sale->client->save();

        return back()->withStatus('Venta finalizada.');
    }

    public function addproduct(Sale $sale)
    {

        $products = Product::where('type', '<>', 1)->get();

        return view('sales.addproduct', compact('sale', 'products'));
    }

    public function storeproduct(Request $request, Sale $sale, SoldProduct $soldProduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldProduct->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale])
            ->withStatus('Producto agregado.');
    }

    public function editproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $products = Product::all();

        return view('sales.editproduct', compact('sale', 'soldproduct', 'products'));
    }

    public function updateproduct(Request $request, Sale $sale, SoldProduct $soldproduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldproduct->update($request->all());

        return redirect()->route('sales.show', $sale)->withStatus('Producto modificado.');
    }

    public function destroyproduct(Sale $sale, SoldProduct $soldproduct)
    {
        $soldproduct->delete();

        return back()->withStatus('Producto eliminado.');
    }

    public function addtransaction(Sale $sale)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.addtransaction', compact('sale', 'payment_methods'));
    }

    public function storetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        $request->merge(['branch_id' => session('dBranch')]);

        switch ($request->all()['type']) {
            case 'income':
                $request->merge(['title' => 'Ingreso recibido de la venta ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Gasto a cliente por venta ID: ' . $request->get('sale_id')]);

                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }

        $transaction->create($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Transacción registrada.');
    }

    public function edittransaction(Sale $sale, Transaction $transaction)
    {
        $payment_methods = PaymentMethod::all();

        return view('sales.edittransaction', compact('sale', 'transaction', 'payment_methods'));
    }

    public function updatetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch ($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Ingreso recibido de la venta ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Gasto a cliente por venta ID: ' . $request->get('sale_id')]);

                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Transacción modificada.');
    }

    public function destroytransaction(Sale $sale, Transaction $transaction)
    {
        $transaction->delete();

        return back()->withStatus('Transacción eliminada.');
    }

    public function printReceipt(Sale $sale)
    {
        $customPaper = array(0, 0, 300.00, 500);

        $pdf = PDF::loadView('prints.sales.comprobante-comun', compact('sale'))->setPaper($customPaper);
        return $pdf->stream();
    }
}
