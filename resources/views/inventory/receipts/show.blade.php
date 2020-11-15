@extends('layouts.app', ['page' => 'Compra', 'pageSlug' => 'receipts', 'section' => 'transactions'])


@section('content')
@include('alerts.success')
@include('alerts.error')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Resumen | <span class="badge badge-pill badge-warning">{{ format_money($receipt->transactions->where('type', 'payment')->sum('amount')) }} / {{ format_money($receipt->products->sum('total_amount')) }}</span></h4>
                    </div>
                    @if (!$receipt->finalized_at)
                    <div class="col-4 text-right">
                        @if ($receipt->products->count() === 0 || $receipt->transactions->count() === 0)
                        <form action="{{ route('receipts.destroy', $receipt) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Eliminar
                            </button>
                        </form>
                        @else
                        <button type="button" class="btn btn-sm btn-primary" onclick="confirm('ATENCIÓN: Al finalizar, no podrás más alterar esta compra') ? window.location.replace('{{ route('receipts.finalize', $receipt) }}') : ''">
                            Finalizar
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Título</th>
                        <th>Usuario</th>
                        <th>Proveedor</th>
                        <th>Productos</th>
                        <th>Cant. Total</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $receipt->id }}</td>
                            <td>{{ date('d-m-y', strtotime($receipt->created_at)) }}</td>
                            <td style="max-width:150px;">{{ $receipt->title }}</td>
                            <td>{{ $receipt->user->name }}</td>
                            <td>
                                @if($receipt->provider_id)
                                <a href="{{ route('providers.show', $receipt->provider) }}">{{ $receipt->provider->name }}</a>
                                @else
                                N/A
                                @endif
                            </td>
                            <td>{{ $receipt->products->count() }}</td>
                            <td>{{ $receipt->products->sum('qty') }}</td>
                            <td>{!! $receipt->finalized_at ? "<span class='badge badge-primary badge-pill'>Finalizado el <br> " . date('d-m-y', strtotime($receipt->finalized_at)) . "</span>" : (($receipt->products->count() > 0) ? "<span class='bage badge-success badge-pill'>A FINALIZAR</span>" : "<span class='bage badge-success badge-pill'>EN ABIERTO</span>") !!}</td>
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
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Productos: {{ $receipt->products->count() }}</h4>
                    </div>
                    @if (!$receipt->finalized_at)
                    <div class="col-4 text-right">
                        <a href="{{ route('receipts.product.add', ['receipt' => $receipt]) }}" class="btn btn-sm btn-primary">Nuevo</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <th>Categoría</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Total</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($receipt->products as $received_product)
                        <tr>
                            <td><a href="{{ route('categories.show', $received_product->product->category) }}">{{ $received_product->product->category->name }}</a></td>
                            <td><a href="{{ route('products.show', $received_product->product) }}">{{ $received_product->product->name }}</a></td>
                            <td>{{ $received_product->qty }}</td>
                            <td>Gs {{ $received_product->cost }}</td>
                            <td>{{ format_money($received_product->total_amount) }}</td>
                            <td class="td-actions text-right">
                                @if(!$receipt->finalized_at)
                                <a href="{{ route('receipts.product.edit', ['receipt' => $receipt, 'receivedproduct' => $received_product]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Pedido">
                                    <i class="tim-icons icon-pencil"></i>
                                </a>
                                <form action="{{ route('receipts.product.destroy', ['receipt' => $receipt, 'receivedproduct' => $received_product]) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Pedido" onclick="confirm('Estás seguro que quieres eliminar este producto?') ? this.parentElement.submit() : ''">
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

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Transacciones: {{ format_money($receipt->transactions->where('type', 'payment')->sum('amount')) }}</h4>

                    </div>
                    @if (!$receipt->finalized_at)
                    <div class="col-4 text-right">
                        <a href="{{ route('inventory.receipts.transaction.add', ['receipt' => $receipt->id]) }}" class="btn btn-sm btn-primary">Nuevo </a>

                    </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                    <div class="table-responsive">
                <table class="table tablesorter " id="">
                        <thead class=" text-primary">
                    <th scope="col">Fecha</th>
                    <th scope="col">Título</th>
                    <th scope="col">Método</th>
                    <th scope="col">Monto</th>
                    <th scope="col">Referencia</th>
                    <th scope="col"></th>
                    </thead>
                    <tbody>
                        @foreach ($receipt->transactions as $transaction)
                        <tr>
                            <td> {{ date('d-m-y', strtotime($transaction->created_at)) }}</td>
                            <td> {{ $transaction->title }}</td>
                            <td><a href="{{ route('methods.show', $transaction->method) }}">{{ $transaction->method->name }}</a></td>
                            <td>{{ format_money($transaction->amount) }}</td>
                            <td>{{ $transaction->reference }}</td>
                            <td></td>
                            <td class="td-actions text-right">
                                @if(!$receipt->finalized_at)
                                <a href="{{ route('inventory.receipts.transaction.edit', ['receipt' => $receipt, 'transaction' => $transaction]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Pedido">
                                    <i class="tim-icons icon-pencil"></i>
                                </a>
                                <form action="{{ route('inventory.receipts.transaction.destroy', ['receipt' => $receipt, 'transaction' => $transaction]) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Pedido" onclick="confirm('Estás seguro que quieres eliminar este pedido de producto/s? Su registro será eliminado de esta venta.') ? this.parentElement.submit() : ''">
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
</div>
@endsection

@push('js')
<script src="{{config('app.url')}}/assets/js/sweetalerts2.js"></script>
@endpush
