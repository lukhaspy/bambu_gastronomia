@extends('layouts.app', ['page' => 'Info del Proveedor', 'pageSlug' => 'providers', 'section' => 'providers'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Info del Proveedor</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Info de Pago</th>
                        <th>Pagos Hechos</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $provider->id }}</td>
                            <td>{{ $provider->name }}</td>
                            <td>{{ $provider->description }}</td>
                            <td>{{ $provider->email }}</td>
                            <td>{{ $provider->phone }}</td>
                            <td style="max-width: 175px">{{ $provider->paymentinfo }}</td>
                            <td>{{ $provider->transactions->count() }}</td>
                            <td>{{ format_money(abs($provider->transactions->sum('amount'))) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Últ. Pagos</h4>
            </div>
            <div class="card-body  table-responsive">
                <table class="table">
                    <thead>
                        <th>Fecha</th>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Método</th>
                        <th>Monto</th>
                        <th>Referencia</th>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ date('d-m-y', strtotime($transaction->created_at)) }}</td>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->title }}</td>
                            <td><a href="{{ route('methods.show', $transaction->method) }}">{{ $transaction->method->name }}</a></td>
                            <td>{{ format_money($transaction->amount) }}</td>
                            <td>{{ $transaction->reference }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Últ. Compras</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <th>Fecha</th>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Productos</th>
                        <th>Stock</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($receipts as $receipt)
                        <tr>
                            <td>{{ date('d-m-y', strtotime($receipt->created_at)) }}</td>
                            <td><a href="{{ route('receipts.show', $receipt) }}">{{ $receipt->id }}</a></td>
                            <td>{{ $receipt->title }}</td>
                            <td>{{ $receipt->products->count() }}</td>
                            <td>{{ $receipt->products->sum('stock') }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ route('receipts.show', $receipt) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Ver Receipt">
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
@endsection