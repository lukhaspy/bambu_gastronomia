@extends('layouts.app', ['page' => 'Info de Métodos', 'pageSlug' => 'methods', 'section' => 'methods'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Info de Métodos</h4>
            </div>
            <div class="card-body">
            <div class=" table-responsive">
                <table class="table ">
                    <thead>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Transacciones</th>
                        <th>Balance Diario</th>
                        <th>Balance Semanal</th>
                        <th>Balance Trimestral</th>
                        <th>Balance Mensual</th>
                        <th>Balance Anual</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $method->id }}</td>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->description }}</td>
                            <td>{{ $method->transactions->count() }}</td>
                            <td>{{ format_money($balances['diario']) }}</td>
                            <td>{{ format_money($balances['semanal']) }}</td>
                            <td>{{ format_money($balances['trimestral']) }}</td>
                            <td>{{ format_money($balances['mensual']) }}</td>
                            <td>{{ format_money($balances['anual']) }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transacciones: {{ $transactions->count() }}</h4>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Título</th>
                        <th>Monto</th>
                        <th>Referencia</th>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ date('d-m-y', strtotime($transaction->created_at)) }}</td>
                            <td><a href="{{ route('transactions.type', $transaction->type) }}">{{ $transactionname[$transaction->type] }}</a></td>
                            <td>{{ $transaction->title }}</td>
                            <td>{{ format_money($transaction->amount) }}</td>
                            <td>{{ $transaction->reference }}</td>
                            <td class="td-actions text-right">
                                @if ($transaction->sale_id)
                                <a href="{{ route('sales.show', $transaction->sale) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                    <i class="tim-icons icon-zoom-split"></i>
                                </a>
                                @elseif ($transaction->transfer_id)

                                @else
                                <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Transaction">
                                    <i class="tim-icons icon-pencil"></i>
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Transaction" onclick="confirm('Tenes certeza de eliminar esta transaccion?') ? this.parentElement.submit() : ''">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection