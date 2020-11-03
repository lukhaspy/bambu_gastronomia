@extends('layouts.app', ['page' => 'Estat. Inventario', 'pageSlug' => 'istats', 'section' => 'inventory'])

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Productos por Proveedor</h4>
            </div>
            <div>
                <form method="get" action="{{ route('inventory.stats') }}" autocomplete="off">
                    <div class="col-12 pl-lg-5">
                        <div class="row">

                            <div class="col-12 col-md-3">
                                <div class="form-group{{ $errors->has('provider_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-provider">Proveedor</label>
                                    <select name="provider_id" id="input-provider" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}">
                                        <option value="">TODOS</option>

                                        @foreach ($providers as $provider)
                                        @if($provider['id'] == old('provider_id') )
                                        <option value="{{$provider['id']}}" selected>{{$provider['name']}}</option>
                                        @elseif(isset($_GET['provider_id']) && $provider['id'] == $_GET['provider_id'])
                                        <option value="{{$provider['id']}}" selected>{{$provider['name']}}</option>
                                        @else
                                        <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'provider_id'])
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-product">Producto</label>
                                    <select name="product_id" id="input-product" class="form-select2 form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}">
                                        <option value="">TODOS</option>

                                        @foreach ($products as $product)
                                        @if($product['id'] == old('product_id') )
                                        <option value="{{$product['id']}}" selected>{{$product['name']}}</option>
                                        @elseif(isset($_GET['product_id']) && $product['id'] == $_GET['product_id'])
                                        <option value="{{$product['id']}}" selected>{{$product['name']}}</option>
                                        @else
                                        <option value="{{$product['id']}}">{{$product['name']}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'product_id'])
                                </div>
                            </div>
                            <div class="col-2">

                                <button type="submit" class="btn btn-success mt-3 ">
                                    <i class="tim-icons icon-zoom-split"></i>

                                </button>
                            </div>


                        </div>

                    </div>

                </form>
            </div>
            <hr>

            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Min</th>
                        <th>Max</th>

                        <th>Costo Promedio</th>
                        <th>Proveedor</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($productsProviders as $tmp)
                        <tr>
                            <td>{{ $tmp->id }}</td>
                            <td>{{ $tmp->category }}</td>
                            <td>{{ $tmp->name }}</td>
                            <td>{{ format_money($tmp->costMin, 0)  }}</td>
                            <td>{{ format_money($tmp->costMax, 0)  }}</td>

                            <td>{{ format_money($tmp->cost, 0) }}</td>
                            <td>{{ $tmp->provider }}</td>

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
                <h4 class="card-title">Por Cantidad (TOP 15)</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table ">
                    <thead>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Ventas Anuales</th>
                        <th>Precio Promedio</th>
                        <th>Ingreso Anual</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($soldproductsbystock as $soldproduct)
                        <tr>
                            <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product_id }}</a></td>
                            <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                            <td>{{ $soldproduct->product->name }}</td>
                            <td>{{ $soldproduct->product->stock }}</td>
                            <td>{{ $soldproduct->total_qty }}</td>
                            <td>{{ format_money(round($soldproduct->avg_price, 2)) }}</td>
                            <td>{{ format_money($soldproduct->incomes) }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ route('products.show', $soldproduct->product) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
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
<div class="row">
    <div class="col-md-6">
        <div class="card card-tasks">
            <div class="card-header">
                <h4 class="card-title">Por Ingreso (TOP 15)</h4>
            </div>
            <div class="card-body">
                <div class="table-full-width table-responsive">
                    <table class="table ">
                        <thead>
                            <th>ID</th>
                            <th>Categoría</th>
                            <th>Nombre</th>
                            <th>Vendido</th>
                            <th>Ingreso</th>
                        </thead>
                        <tbody>
                            @foreach ($soldproductsbyincomes as $soldproduct)
                            <tr>
                                <td>{{ $soldproduct->product_id }}</td>
                                <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product->name }}</a></td>
                                <td>{{ $soldproduct->total_qty }}</td>
                                <td>{{ format_money($soldproduct->incomes) }}</td>
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
                <h4 class="card-title">Por precio promedio (TOP 15)</h4>
            </div>
            <div class="card-body">
                <div class="table-full-width table-responsive">
                    <table class="table">
                        <thead>
                            <th>ID</th>
                            <th>Categoría</th>
                            <th>Nombre</th>
                            <th>Vendido</th>
                            <th>Precio Promedio</th>
                        </thead>
                        <tbody>
                            @foreach ($soldproductsbyavgprice as $soldproduct)
                            <tr>
                                <td>{{ $soldproduct->product_id }}</td>
                                <td><a href="{{ route('categories.show', $soldproduct->product->category) }}">{{ $soldproduct->product->category->name }}</a></td>
                                <td><a href="{{ route('products.show', $soldproduct->product) }}">{{ $soldproduct->product->name }}</a></td>
                                <td>{{ $soldproduct->total_qty }}</td>
                                <td>{{ format_money(round($soldproduct->avg_price, 2)) }}</td>
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
<script>
    new SlimSelect({
        select: '.form-select'
    })
    new SlimSelect({
        select: '.form-select2'
    })
</script>
@endpush