@extends('layouts.app', ['pageSlug' => 'tstats', 'page' => 'Estatísticas', 'section' => 'transactions'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Estatísticas de Operaciones</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-primary">
                            Ver Operaciones
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive">
                    <thead>
                        <th>Mes</th>
                        <th>Cant.</th>
                        <th>Ingresos</th>
                        <th>Salidas</th>
                        <th>Pagamentos</th>
                        <th>Efectivo</th>
                        <th>Total</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($transactionsperiods as $period => $data)
                        <tr>
                            <td>{{ $period }}</td>
                            <td>{{ $data->count() }}</td>
                            <td>{{ format_money($data->where('type', 'income')->sum('amount')) }}</td>
                            <td>{{ format_money($data->where('type', 'expense')->sum('amount')) }}</td>
                            <td>{{ format_money($data->where('type', 'payment')->sum('amount')) }}</td>
                            <td>{{ format_money($data->where('payment_method_id', optional($methods->where('name', 'Cash')->first())->id)->sum('amount')) }}</td>
                            <td>{{ format_money($data->sum('amount')) }}</td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-tasks">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Ventas Pendientes</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('clients.index') }}" class="btn btn-sm btn-primary">Ver Clientes</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-full-width table-responsive">
                    <table class="table table-responsive">
                        <thead>
                            <th>Cliente</th>
                            <th>Compras</th>
                            <th>Transacciones</th>
                            <th>Saldo</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                            <tr>
                                <td><a href="{{ route('clients.show', $client) }}">{{ $client->name }}<br>{{ $client->document_type }}-{{ $client->document_id }}</a></td>
                                <td>{{ $client->sales->count() }}</td>
                                <td>{{ format_money($client->transactions->sum('amount')) }}</td>
                                <td>
                                    @if ($client->balance > 0)
                                    <span class="text-success">{{ format_money($client->balance) }}</span>
                                    @elseif ($client->balance < 0.00) <span class="text-danger">{{ format_money($client->balance) }}</span>
                                        @else
                                        {{ format_money($client->balance) }}
                                        @endif
                                </td>
                                <td>
                                    <a href="{{ route('clients.transactions.add', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Register Transation">
                                        <i class="tim-icons icon-simple-add"></i>
                                    </a>
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="See Client">
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

    <div class="col-md-6">
        <div class="card card-tasks">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Estatística Por Método</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('methods.index') }}" class="btn btn-sm btn-primary">Ver Métodos</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-full-width table-responsive">
                    <table class="table table-responsive">
                        <thead>
                            <th>Método</th>
                            <th>Transacciones {{ $date->year }}</th>
                            <th>Saldo {{ $date->year }}</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach($methods as $method)
                            <tr>
                                <td><a href="{{ route('methods.show', $method) }}">{{ $method->name }}</a></td>
                                <td>{{ format_money($transactionsperiods['Año']->where('payment_method_id', $method->id)->count()) }}</td>
                                <td>{{ format_money($transactionsperiods['Año']->where('payment_method_id', $method->id)->sum('amount')) }}</td>
                                <td>
                                    <a href="{{ route('methods.show', $method) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="See Method">
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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Estatísticas Ventas</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">Ver Ventas</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive">
                    <thead class="bg-light">
                        <th>Periodo</th>
                        <th>Ventas</th>
                        <th>Clientes</th>
                        <th>Total Stock</th>
                        <th data-toggle="tooltip" data-placement="bottom" title="Promedio de ingresos por cada venta">Promedio Ing x Venta</th>
                        <th>Monto Cobrado</th>
                        <th>Finalizados</th>
                    </thead>
                    <tbody>
                        @foreach ($salesperiods as $period => $data)
                        <tr>
                            <td>{{ $period }}</td>
                            <td>{{ $data->count() }}</td>
                            <td>{{ $data->groupBy('client_id')->count() }}</td>
                            <td>{{ $data->where('finalized_at', '!=', null)->map(function ($sale) {return $sale->products->sum('qty');})->sum() }}</td>
                            <td>{{ format_money($data->avg('total_amount')) }}</td>
                            <td>{{ format_money($data->where('finalized_at', '!=', null)->map(function ($sale) {return $sale->products->sum('total_amount');})->sum()) }}</td>
                            <td>{{ $data->where('finalized_at', null)->count() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection