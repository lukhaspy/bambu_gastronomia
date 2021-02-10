<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Client;
use App\Provider;
use Carbon\Carbon;
use App\SoldProduct;
use App\Transaction;
use App\PaymentMethod;
use App\SpendingProfile;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactionname = [
            'income' => 'Entrada',
            'payment' => 'Pagamento',
            'expense' => 'Salida',
            'transferencia' => 'Transferencia'
        ];

        $transactions = Transaction::latest()->paginate(25);

        return view('transactions.index', compact('transactions', 'transactionname'));
    }

    public function stats()
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $salesperiods = [];
        $transactionsperiods = [];

        $salesperiods['Día'] = Sale::whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->get();
        $transactionsperiods['Día'] = Transaction::whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->get();

        $salesperiods['Ayer'] = Sale::whereBetween('created_at', [Carbon::now()->subDay(1)->startOfDay(), Carbon::now()->subDay(1)->endOfDay()])->get();
        $transactionsperiods['Ayer'] = Transaction::whereBetween('created_at', [Carbon::now()->subDay(1)->startOfDay(), Carbon::now()->subDay(1)->endOfDay()])->get();

        $salesperiods['Semana'] = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $transactionsperiods['Semana'] = Transaction::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        $salesperiods['Mes'] = Sale::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $transactionsperiods['Mes'] = Transaction::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

        $salesperiods['Trimestre'] = Sale::whereBetween('created_at', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])->get();
        $transactionsperiods['Trimestre'] = Transaction::whereBetween('created_at', [Carbon::now()->startOfQuarter(), Carbon::now()->endOfQuarter()])->get();

        $salesperiods['Año'] = Sale::whereYear('created_at', Carbon::now()->year)->get();
        $transactionsperiods['Año'] = Transaction::whereYear('created_at', Carbon::now()->year)->get();

        return view('transactions.stats', [
            'clients'               => Client::where('balance', '!=', '0.00')->get(),
            'salesperiods'          => $salesperiods,
            'transactionsperiods'   => $transactionsperiods,
            'date'                  => Carbon::now(),
            'methods'               => PaymentMethod::all()
        ]);
    }

    public function type($type)
    {
        switch ($type) {
            case 'expense':
                return view('transactions.expense.index', ['transactions' => Transaction::where('type', 'expense')->latest()->paginate(25)]);

            case 'payment':
                return view('transactions.payment.index', ['transactions' => Transaction::where('type', 'payment')->latest()->paginate(25)]);

            case 'income':
                return view('transactions.income.index', ['transactions' => Transaction::where('type', 'income')->latest()->paginate(25)]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        switch ($type) {
            case 'expense':
                return view('transactions.expense.create', [
                    'payment_methods' => PaymentMethod::all(),
                    'spendingProfiles' => SpendingProfile::all()
                ]);

            case 'payment':
                return view('transactions.payment.create', [
                    'payment_methods' => PaymentMethod::all(),
                    'providers' => Provider::all(),
                ]);

            case 'income':
                return view('transactions.income.create', [
                    'payment_methods' => PaymentMethod::all(),
                ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Transaction $transaction)
    {
        $request->merge(['branch_id' => session('dBranch')]);

        if ($request->get('client_id')) {
            switch ($request->get('type')) {
                case 'income':
                    $request->merge(['title' => 'Pagamento recibido por cliente ID: ' . $request->get('client_id')]);
                    break;

                case 'expense':
                    $request->merge(['title' => 'Retorno hecho al cliente ID: ' . $request->get('client_id')]);

                    if ($request->get('amount') > 0) {
                        $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                    }
                    break;
            }

            $transaction->create($request->all());
            $client = Client::find($request->get('client_id'));
            $client->balance += $request->get('amount');
            $client->save();

            return redirect()
                ->route('clients.show', $request->get('client_id'))
                ->withStatus('Transacción Registrada.');
        }

        switch ($request->get('type')) {

            case 'expense':
                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => ((float) $request->get('amount') * (-1))]);
                }
                if (!$request['spendingProfile_id']) {
                    return redirect()
                        ->back()
                        ->withErrors('Debes seleccionar un perfil')
                        ->withInput();
                }

                $transaction->create($request->all());

                return redirect()
                    ->route('transactions.type', ['type' => 'expense'])
                    ->withStatus('Salida registrada.');

            case 'payment':
                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => ((float) $request->get('amount') * (-1))]);
                }
                if (!$request['provider_id']) {
                    return redirect()
                        ->back()
                        ->withErrors('Debes seleccionar un proveedor')
                        ->withInput();
                }
                $transaction->create($request->all());

                return redirect()
                    ->route('transactions.type', ['type' => 'payment'])
                    ->withStatus('Pagamento registrado.');

            case 'income':

                $transaction->create($request->all());

                return redirect()
                    ->route('transactions.type', ['type' => 'income'])
                    ->withStatus('Entrada registrada.');

            default:
                return redirect()
                    ->route('transactions.index')
                    ->withStatus('Transacción registrada.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        switch ($transaction->type) {
            case 'expense':
                return view('transactions.expense.edit', [
                    'transaction' => $transaction,
                    'payment_methods' => PaymentMethod::all(),
                    'spendingProfiles' => SpendingProfile::all(),

                ]);

            case 'payment':
                return view('transactions.payment.edit', [
                    'transaction' => $transaction,
                    'payment_methods' => PaymentMethod::all(),
                    'providers' => Provider::all()
                ]);

            case 'income':
                return view('transactions.income.edit', [
                    'transaction' => $transaction,
                    'payment_methods' => PaymentMethod::all(),
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        switch ($request->get('type')) {
            case 'expense':
                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => ((float) $request->get('amount') * (-1))]);
                }
                return redirect()
                    ->route('transactions.type', ['type' => 'expense'])
                    ->withStatus('Salida registrada.');

            case 'payment':
                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => ((float) $request->get('amount') * (-1))]);
                }

                return redirect()
                    ->route('transactions.type', ['type' => 'payment'])
                    ->withStatus('Pagamento registrado.');

            case 'income':
                return redirect()
                    ->route('transactions.type', ['type' => 'income'])
                    ->withStatus('Entrada registrada.');

            default:
                return redirect()
                    ->route('transactions.index')
                    ->withStatus('Transacción registrada.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //if ($transaction->sale)
        //{
        //    return back()->withStatus('You cannot remove a transaction from a completed sale. You can delete the sale and its entire record.');
        //}

        if ($transaction->transfer) {
            return back()->withStatus('No puedes remover una transacción de una transferencia.
            Debes eliminar la transferencia para eliminar sus registros.');
        }

        $type = $transaction->type;

        if ($transaction->client_id) {
            $client = Client::find($transaction->client_id);
            $client->balance -=  $transaction->amount;
            $client->update();
        }
        $transaction->delete();


        switch ($type) {
            case 'expense':
                return back()->withStatus('Salida eliminada.');

            case 'payment':
                return back()->withStatus('Pagamento eliminado.');

            case 'income':
                return back()->withStatus('Entrada eliminada.');

            default:
                return back()->withStatus('Transacción eliminada.');
        }
    }
}
