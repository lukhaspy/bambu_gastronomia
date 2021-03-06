<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Client;
use App\Transaction;
use App\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(25);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\ClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request, Client $client)
    {
        $request->merge(['branch_id' => session('dBranch')]);
        $client->create($request->all());

        return redirect()->route('clients.index')->withStatus('Cliente Agregado Correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\ClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->all());

        return redirect()
            ->route('clients.index')
            ->withStatus('Cliente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if ($client->sales()->count()) {

            return redirect()->route('clients.index')->withStatus('NO ES POSIBLE ELIMINAR EL CLIENTE, ESTA RELACIONADO CON ALGUNA VENTA.');
        }
        if ($client->transactions()->count()) {

            return redirect()->route('clients.index')->withStatus('NO ES POSIBLE ELIMINAR EL CLIENTE, ESTA RELACIONADO CON ALGUNA TRANSACCION.');
        }

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->withStatus('Cliente Eliminado Correctamente');
    }

    public function addtransaction(Client $client)
    {
        $payment_methods = PaymentMethod::all();

        return view('clients.transactions.add', compact('client', 'payment_methods'));
    }
}
