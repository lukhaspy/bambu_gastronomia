<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use App\Receipt;
use App\Provider;
use App\Product;
use App\Http\Requests\ReceiptRequest;

use Carbon\Carbon;
use App\ReceivedProduct;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Receipt  $model
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $receipts = Receipt::paginate(25);

        return view('inventory.receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = Provider::all();

        return view('inventory.receipts.create', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptRequest $request, Receipt $receipt)
    {
        $request->merge(['branch_id' => session('dBranch')]);
        $receipt = $receipt->create($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Compra registrada, ahora puedes agregar productos y  transacciones.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        return view('inventory.receipts.show', compact('receipt'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        if (!$receipt->finalized_at) {

            $receipt->products()->delete();
            $receipt->transactions()->delete();
            $receipt->delete();

            return redirect()
                ->route('receipts.index')
                ->withStatus('Compra eliminada.');
        } else {
            return redirect()
                ->route('receipts.index')
                ->withErrors('La compra no puede ser eliminada, ya esta finalizada.');
        }
    }

    /**
     * Finalize the Receipt for stop adding products.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function finalize(Receipt $receipt)
    {
        if (!($receipt->transactions->sum('amount') * (-1) >= $receipt->products()->sum('total_amount'))) {
            return back()->withStatus('Las transacciones no coinciden con el valor de los productos');
        }
        $receipt->finalized_at = Carbon::now()->toDateTimeString();
        $receipt->save();

        foreach ($receipt->products as $receivedproduct) {
            $receivedproduct->product->stock += $receivedproduct->qty;
            $receivedproduct->product->save();
        }

        return back()->withStatus('Compra finalizada.');
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function addproduct(Receipt $receipt)
    {
        $products = Product::where('type', '<>', 2)->with('receiveds.receipt')->get();

        $productIds = [];
        foreach ($products as $p) {
            $productIds[] = $p->id;
        }

        $providerReceipts = Receipt::select(DB::raw('avg(received_products.cost) as avg,
         max(received_products.cost) as max,
          min(received_products.cost) as min,
            received_products.product_id,
            products.unity'))
            ->join('received_products', 'receipts.id', '=', 'received_products.receipt_id')
            ->join('products', 'received_products.product_id', '=', 'products.id')
            ->where('receipts.provider_id', $receipt->provider_id)
            ->where('receipts.branch_id', $receipt->branch_id)
            ->whereIn('received_products.product_id', $productIds)
            ->groupBy('received_products.product_id')
            ->withoutGlobalScopes()
            ->get();

        return view('inventory.receipts.addproduct', compact('receipt', 'products', 'providerReceipts'));
    }

    public function addtransaction(Receipt $receipt)
    {

        $payment_methods = PaymentMethod::all();

        return view('inventory.receipts.addtransaction', compact('receipt', 'payment_methods'));
    }


    public function storetransaction(Request $request, Receipt $receipt, Transaction $transaction)
    {
        switch ($request->all()['type']) {

            case 'payment':
                $request->merge(['title' => 'Pago a proveedor por compra ID: ' . $request->get('receipt_id')]);

                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }

        $transaction->create($request->all());

        return redirect()
            ->route('receipts.show', compact('receipt'))
            ->withStatus('Transacción registrada.');
    }

    public function edittransaction(Receipt $receipt, Transaction $transaction)
    {
        $payment_methods = PaymentMethod::all();

        return view('inventory.receipts.edittransaction', compact('receipt', 'transaction', 'payment_methods'));
    }

    public function updatetransaction(Request $request, Receipt $receipt, Transaction $transaction)
    {
        switch ($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Ingreso recibido de la venta ID: ' . $request->get('receipt_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Gasto a cliente por venta ID: ' . $request->get('receipt_id')]);

                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('receipts.show', compact('receipt'))
            ->withStatus('Transacción modificada.');
    }

    public function destroytransaction(Receipt $receipt, Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Transacción eliminada.');
    }
    /**
     * Add product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function storeproduct(Request $request, Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $request->merge(['total_amount' => $request->get('cost') * $request->get('qty')]);

        $receivedproduct->create($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Producto agregado.');
    }

    /**
     * Editor product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function editproduct(Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $products = Product::where('type', '<>', 2)->with('receiveds.receipt')->get();

        $productIds = [];
        foreach ($products as $p) {
            $productIds[] = $p->id;
        }

        $providerReceipts = Receipt::select(DB::raw('avg(received_products.cost) as avg,
         max(received_products.cost) as max,
          min(received_products.cost) as min,
            received_products.product_id,
            products.unity'))
            ->join('received_products', 'receipts.id', '=', 'received_products.receipt_id')
            ->join('products', 'received_products.product_id', '=', 'products.id')
            ->where('receipts.provider_id', $receipt->provider_id)
            ->whereIn('received_products.product_id', $productIds)
            ->groupBy('received_products.product_id')
            ->get();
        return view('inventory.receipts.editproduct', compact('receipt', 'providerReceipts', 'receivedproduct', 'products'));
    }

    /**
     * Update product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function updateproduct(Request $request, Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->update($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Producto actualizado.');
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroyproduct(Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->delete();

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Producto eliminado.');
    }
}
