@extends('layouts.app', ['page' => 'Ventas', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
@include('alerts.success')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Ventas</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary">Registrar Venta</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive"">
                    <table class=" table ">
                        <thead>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Cant. Productos</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            <tr>
                                <td>{{ date('d-m-y', strtotime($sale->created_at)) }}</td>
                                <td><a href=" {{ route('clients.show', $sale->client) }}">{{ $sale->client->name }}<br>{{ $sale->client->document_type }}-{{ $sale->client->document_id }}</a></td>
                    <td>{{ $sale->user->name }}</td>
                    <td>{{ $sale->products->count() }}</td>
                    <td>{{ $sale->products->sum('qty') }}</td>
                    <td><span class="badge badge-pill badge-warning">{{ format_money($sale->transactions->where('type', 'income')->sum('amount')) }} / {{ format_money($sale->products->sum('total_amount')) }}</span></td>
                    <td>
                        @if($sale->finalized_at)
                        <span class="badge badge-pill badge-primary">Finalizado</span>
                        @else
                        <span class="badge badge-pill badge-success">En Abierto</span>
                        @endif
                    </td>
                    <td class="td-actions text-right">
                        @if (!$sale->finalized_at)
                        <a href="{{ route('sales.show', ['sale' => $sale]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Editar">
                            <i class="tim-icons icon-pencil"></i>
                        </a>
                        <form action="{{ route('sales.destroy', $sale) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onclick="confirm('Deseas realmente eliminar esta venta?') ? this.parentElement.submit() : ''">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('sales.show', ['sale' => $sale]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Ver">
                            <i class="tim-icons icon-zoom-split"></i>
                        </a>
                        @endif

                    </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $sales->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection