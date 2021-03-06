@extends('layouts.app', ['page' => 'Compra', 'pageSlug' => 'receipts', 'section' => 'transactions'])

@section('content')
@include('alerts.success')
<div class="row">
    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h4 class="card-title">Compras</h4>
                </div>
                <div class="col-4 text-right">
                    <a href="{{ route('receipts.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class=" table-responsive">
                <table class="table">
                    <thead>
                        <th>Fecha</th>
                        <th>Título</th>
                        <th>Proveedor</th>
                        <th>Productos</th>
                        <th>Cant. Total</th>
                        <th>Totales</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($receipts as $receipt)
                        <tr>
                            <td>{{ date('d-m-y', strtotime($receipt->created_at)) }}</td>
                            <td style="max-width:150px">{{ $receipt->title }}</td>
                            <td>
                                @if($receipt->provider_id)
                                <a href="{{ route('providers.show', $receipt->provider) }}">{{ $receipt->provider->name }}</a>
                                @else
                                N/A
                                @endif
                            </td>
                            <td>{{ $receipt->products->count() }}</td>
                            <td>{{ $receipt->products->sum('qty') }}</td>
                            <td><span class="badge badge-pill badge-warning">{{ format_money($receipt->transactions->where('type', 'payment')->sum('amount')) }} / {{ format_money($receipt->products->sum('total_amount')) }}</span></td>
                            <td>
                                @if($receipt->finalized_at)
                                <span class="badge badge-pill badge-primary">Finalizado</span>
                                @else
                                <span class="badge badge-pill badge-success">En Abierto</span>
                                @endif
                            </td>
                            <td class="td-actions text-right">
                                @if($receipt->finalized_at)
                                <a href="{{ route('receipts.show', ['receipt' => $receipt]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Ver Receipt">
                                    <i class="tim-icons icon-zoom-split"></i>
                                </a>
                                @else
                                <a href="{{ route('receipts.show', ['receipt' => $receipt]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Receipt">
                                    <i class="tim-icons icon-pencil"></i>
                                </a>
                                <form action="{{ route('receipts.destroy', $receipt) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Receipt" onclick="confirm('Estás seguro que quieres eliminar este recibo? Todos sus registros serán eliminados permanentemente, si ya está finalizado el stock de los productos permanecerán.') ? this.parentElement.submit() : ''">
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
        <div class="card-footer py-4">
            <nav class="d-flex justify-content-end" aria-label="...">
                {{ $receipts->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection