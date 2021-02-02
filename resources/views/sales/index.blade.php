@extends('layouts.app', ['page' => 'Venta', 'pageSlug' => 'sales', 'section' => 'transactions'])

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
                        <a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('sales.index')}}">
                    <div class="row">

                        <div class="col-md-3">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <label class="form-control-label" for="input-name">Cliente - Todos <input type="checkbox" name="todos_clientes" @isset($_GET['todos_clientes']) {{'checked'}} @endisset></label>
                            <select name="cliente" id="input-category" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}">
                                @foreach ($clients as $client)
                                @if(isset($_GET['cliente']))
                                @if($client['id'] == $_GET['cliente'])
                                <option value="{{$client['id']}}" selected>{{$client['name']}} - {{$client['document_type'].$client['document_id']}}</option>
                                @endif
                                @endif

                                <option value="{{$client['id']}}">{{$client['name']}} - {{$client['document_type'].$client['document_id']}}</option>


                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'cliente'])
                        </div>
                        <div class="col-md-2">
                            <label for="">Desde</label>
                            <input type="date" name="desde" value="{{(isset($_GET['desde'])) ? $_GET['desde'] : date('Y-m-d', strtotime('-7 days'))}}" class="form-control">

                        </div>
                        <div class="col-md-2">
                            <label for="">Hasta</label>
                            <input type="date" name="hasta" value="{{(isset($_GET['hasta'])) ? $_GET['hasta'] :date('Y-m-d')}}" class="form-control">

                        </div>
                        <div class="col-md-2">
                            <label for="">Ordenar</label>
                            <select name="orden" class="form-control" id="orden">
                                <option value="fecha_desc" {{(isset($_GET['orden']) && $_GET['orden'] == 'fecha_desc') ? 'selected' : '' }}>Fecha (Ult - Prim)</option>
                                <option value="fecha_asc" {{(isset($_GET['orden']) && $_GET['orden'] == 'fecha_asc') ? 'selected' : '' }}>Fecha (Prim - Ult)</option>
                                <option value="cliente_asc" {{(isset($_GET['orden']) && $_GET['orden'] == 'cliente_asc') ? 'selected' : '' }}>Cliente (A - Z)</option>
                                <option value="cliente_desc" {{(isset($_GET['orden']) && $_GET['orden'] == 'cliente_desc') ? 'selected' : '' }}>Cliente (Z - A)</option>
                                <option value="total_asc" {{(isset($_GET['orden']) && $_GET['orden'] == 'total_asc') ? 'selected' : '' }}>Total (Mayor - Menor)</option>
                                <option value="total_desc" {{(isset($_GET['orden']) && $_GET['orden'] == 'total_desc') ? 'selected' : '' }}>Total (Menor - Mayor)</option>
                            </select>





                        </div>
                        <div class="col-md-2">
                            <label for="" class="control-label">Buscar</label> <br>
                            <button type="submit" class="btn btn-primary"><i class="tim-icons icon-lock-circle"></i></button>
                        </div>

                    </div>
                </form>
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
                                <td>{{ date('d-m-y', strtotime($sale->date)) }}</td>
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
@push('js')
<script>
    new SlimSelect({
        select: '.form-select'
    })
</script>
@endpush