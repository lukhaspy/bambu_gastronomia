@extends('layouts.app', ['page' => 'Venta', 'pageSlug' => 'sales', 'section' => 'transactions'])

@section('content')
@include('alerts.success')
@include('alerts.error')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Resumen | <span class="badge badge-pill badge-warning">{{ format_money($sale->transactions->where('type', 'income')->sum('amount')) }} / {{ format_money($sale->products->sum('total_amount')) }}</span></h4>
                    </div>
                    @if (!$sale->finalized_at)
                    <div class="col-4 text-right">
                        @if ($sale->products->count() == 0 || $sale->transactions->count() === 0)
                        <form action="{{ route('sales.destroy', $sale) }}" method="post" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">
                                Eliminar
                            </button>
                        </form>
                        @else
                        <button type="button" class="btn btn-sm btn-primary" onclick="confirm('ATENCION: Las transacciones de esta venta no coinciden con el costo de los productos, Deseas finalizarla?') ? window.location.replace('{{ route('sales.finalize', $sale) }}') : ''">
                            Finalizar Venta
                        </button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Cliente</th>
                            <th>Cant. Productos</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Operacion</th>

                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ date('d-m-y H:i', strtotime($sale->created_at)) }}</td>
                                <td>{{ $sale->user->name }}</td>
                                <td><a href="{{ route('clients.show', $sale->client) }}">{{ $sale->client->name }}<br>{{ $sale->client->document_type }}-{{ $sale->client->document_id }}</a></td>
                                <td>{{ $sale->products->count() }}</td>
                                <td>{{ $sale->products->sum('qty') }}</td>
                                <td>{{ format_money($sale->products->sum('total_amount')) }}</td>
                                <td>{!! $sale->finalized_at ? "<span class='badge badge-primary badge-pill'>Finalizado el <br> " . date('d-m-y', strtotime($sale->finalized_at)) . "</span>" : (($sale->products->count() > 0) ? "<span class='bage badge-success badge-pill'>A FINALIZAR</span>" : "<span class='bage badge-success badge-pill'>EN ABIERTO</span>") !!}
                                    @if($sale->preparing_at)
                                    <br>
                                    <span class='badge badge-warning badge-pill'>En Preparo: {{date('d/m/Y H:i', strtotime($sale->preparing_at))}}</span>

                                    @endif
                                    @if($sale->prepared_at)
                                    <br>
                                    <span class='badge badge-primary badge-pill'>Preparado: {{date('d/m/Y H:i', strtotime($sale->prepared_at))}}</span>

                                    @endif
                                </td>

                                <td>@if(!$sale->preparing_at && !$sale->finalized_at)
                                    <a href=" {{route('sales.orders.prepare', $sale)}} " class="badge badge-primary badge-pill">Preparar...</a>
                                    @endif

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="row">
            <div class="col-7">
                <div class="card ">
                    <div class="card-header bg-info  ">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="display-5 text-white">Productos: {{ $sale->products->sum('qty') }}</h4>
                            </div>
                            @if (!$sale->finalized_at)
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.product.add', ['sale' => $sale->id]) }}" class="btn btn-sm btn-primary text-white">Agregar </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <th>ID</th>
                                    <th>Categoría</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unit.</th>
                                    <th>Total</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($sale->products as $sold_product)
                                    <tr>
                                        <td>{{ $sold_product->product->id }}</td>
                                        <td><a href="{{ route('categories.show', $sold_product->product->category) }}">{{ $sold_product->product->category->name }}</a></td>
                                        <td><a href="{{ route('products.show', $sold_product->product) }}">{{ $sold_product->product->name }}</a></td>
                                        <td>{{ $sold_product->qty }}</td>
                                        <td>{{ format_money($sold_product->price) }}</td>
                                        <td>{{ format_money($sold_product->total_amount) }}</td>
                                        <td class="td-actions text-right">
                                            @if(!$sale->finalized_at)
                                            <a href="{{ route('sales.product.edit', ['sale' => $sale, 'soldproduct' => $sold_product]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Pedido">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('sales.product.destroy', ['sale' => $sale, 'soldproduct' => $sold_product]) }}" method="post" class="d-inline">
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
            <div class="col-5">
                <div class="card">
                    <div class="card-header bg-info">
                        <div class="row">
                            <div class="col-8">
                                <h4 class="display-5 text-white">Transacciones: {{ format_money($sale->transactions->where('type', 'income')->sum('amount')) }}</h4>

                            </div>
                            @if (!$sale->finalized_at)
                            <div class="col-4 text-right">
                                <a href="{{ route('sales.transaction.add', ['sale' => $sale->id]) }}" class="btn btn-sm btn-primary text-white">Agregar </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class=" table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th scope="col" width="100">Fecha</th>
                                    <th scope="col">Título</th>
                                    <th scope="col">Método</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col"></th>
                                </thead>
                                <tbody>
                                    @foreach ($sale->transactions as $transaction)
                                    <tr>
                                        <td> {{ date('d-m-y H:i', strtotime($transaction->created_at)) }}</td>
                                        <td> {{ $transaction->title }}</td>
                                        <td><a href="{{ route('methods.show', $transaction->method) }}">{{ $transaction->method->name }}</a></td>
                                        <td>{{ format_money($transaction->amount) }}</td>
                                        <td>{{ $transaction->reference }}</td>
                                        <td></td>
                                        <td class="td-actions text-right">
                                            @if(!$sale->finalized_at)
                                            <a href="{{ route('sales.transaction.edit', ['sale' => $sale, 'transaction' => $transaction]) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Pedido">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            <form action="{{ route('sales.transaction.destroy', ['sale' => $sale, 'transaction' => $transaction]) }}" method="post" class="d-inline">
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









    </div>
</div>
</div>
@endsection

@push('js')
<script src="{{config('app.url')}}/assets/js/sweetalerts2.js"></script>
@endpush