@extends('layouts.app', ['page' => 'Info Cliente', 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
@include('alerts.error')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Info Cliente</h4>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <th>Nombre y Cédula</th>

                        <th>Correo / Teléfono</th>
                        <th>Dirección</th>

                        <th>Saldo</th>
                        <th>Compras</th>
                        <th>Pagos Totales</th>
                        <th>Ult. Compra</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $client->name }}<br>{{ $client->surname }}-{{ $client->document_id }}</td>
                            <td>
                                <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                                <br>
                                {{ $client->phone }}
                            </td>
                            <td>{{$client->address}}</td>
                            <td>
                                @if (round($client->balance) > 0)
                                <span class="text-success">{{ format_money($client->balance) }}</span>
                                @elseif (round($client->balance) < 0.00) <span class="text-danger">{{ format_money($client->balance) }}</span>
                                    @else
                                    {{ format_money($client->balance) }}
                                    @endif
                            </td>
                            <td>{{ $client->sales->count() }}</td>
                            <td>{{ format_money($client->transactions->sum('amount')) }}</td>
                            <td>{{ ($client->sales->sortByDesc('created_at')->first()) ? date('d-m-y h:i', strtotime($client->sales->sortByDesc('created_at')->first()->created_at)) : 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-7">
                        <h4 class="card-title">Últ. Transacciones</h4>
                    </div>
                    <div class="col-5 text-right">
                        <a href="{{ route('clients.transactions.add', $client) }}" class="btn btn-sm btn-primary">Nueva Transacción</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Método</th>
                        <th>Monto</th>
                    </thead>
                    <tbody>
                        @foreach ($client->transactions->reverse()->take(25) as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ date('d-m-y', strtotime($transaction->created_at)) }}</td>
                            <td><a href="{{ route('methods.show', $transaction->method) }}">{{ $transaction->method->name }}</a></td>
                            <td>{{ format_money($transaction->amount) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Últ. Ventas</h4>
                    </div>
                    <div class="col-4 text-right">
                        <form method="post" action="{{ route('sales.store') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                            <button type="submit" class="btn btn-sm btn-primary">Nueva Venta</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cant. Productos</th>
                        <th>Stock</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($client->sales->reverse()->take(25) as $sale)
                        <tr>
                            <td><a href="{{ route('sales.show', $sale) }}">{{ $sale->id }}</a></td>
                            <td>{{ date('d-m-y', strtotime($sale->created_at)) }}</td>
                            <td>{{ $sale->products->count() }}</td>
                            <td>{{ $sale->products->sum('qty') }}</td>
                            <td>{{ format_money($sale->products->sum('total_amount')) }}</td>
                            <td>{!! ($sale->finalized_at) ? "<span class='badge badge-primary'>Finalizado</span>" : "<span class='badge badge-success'>En Espera</span>" !!}</td>
                            <td class="td-actions text-right">
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                    <i class="tim-icons icon-zoom-split"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection