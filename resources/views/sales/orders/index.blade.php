@extends('layouts.app', ['page' => 'Pedidos', 'pageSlug' => 'orders', 'section' => 'orders'])

@section('content')
@include('alerts.success')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h3 class="display-5">Pedidos</h3>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <div class="row" id="content">

                        @foreach ($sales as $sale)
                        <div class="alert alert-secondary col-xl-4 col-12 p-5">
                            <div class="alert alert-info text-center">
                                <div class="text-white font-weight-bold display-3">Pedido #{{$sale->id}}</div>
                            </div>

                            <div class="alert alert-info  ">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="text-white font-weight-bold display-4">Cliente: </div>

                                        </div>

                                        <div class="col-8">
                                            <h4 class="text-white">

                                                {{ $sale->client->name }}
                                            </h4>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="text-white font-weight-bold display-4">Preparar: </div>

                                        </div>

                                        <div class="col-6">
                                            <h3 class="text-white text-center bg-primary rounded">

                                                {{ date('d/m/Y H:i', strtotime($sale->preparing_at)) }}
                                            </h3>

                                        </div>
                                    </div>

                                </div>

                                <a href="{{route('sales.orders.prepared', $sale)}}" class="btn btn-secondary col-12">PREPARADO! </a>

                            </div>
                            <hr>
                            <h1>Productos:</h1>

                            @foreach($sale->products as $sold)
                            <div class=" alert alert-success  ">
                                <h5 class="display-4"><span class="bg-secondary p-2  rounded">{{$sold->qty}}</span>

                                    <span class="ml-3">{{$sold->product->name}}</span>
                                </h5>
                            </div>
                            @endforeach

                        </div>

                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'http://localhost:3000/sales/orders/api',
            success(response) {
                addContent(response.sales)
            }
        })
        setInterval(() => {

        }, 2000);


        function addContent(resp) {
            let content = '';
            resp.forEach(function(item, i) {
                content += `
                <div class="alert alert-secondary col-xl-4 col-12 p-5">
                            <div class="alert alert-info text-center">
                                <div class="text-white font-weight-bold display-3">Pedido #${item.id}</div>
                            </div>

                            <div class="alert alert-info  ">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="text-white font-weight-bold display-4">Cliente: </div>

                                        </div>

                                        <div class="col-8">
                                            <h4 class="text-white">

                                            ${item.client.name}
                                            </h4>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="text-white font-weight-bold display-4">Preparar: </div>

                                        </div>

                                        <div class="col-6">
                                            <h3 class="text-white text-center bg-primary rounded">

                                            ${item.preparing_at}
                                            </h3>

                                        </div>
                                    </div>

                                </div>

                                <a href="/sales/orders/prepared/${item.id}" class="btn btn-secondary col-12">PREPARADO! </a>

                            </div>
                            <hr>
                            `;

                item.products.forEach(function(product, j) {
                    content += `
                                            <div class=" alert alert-success  ">
                                            <h5 class="display-4"><span class="bg-secondary p-2  rounded">${product.qty}</span>

                                                <span class="ml-3">${product.product.name}</span>
                                            </h5>
                                        </div>
                                            `;
                })

                content += `</div>`

            })

            $('#content').html(content)

        }
    })
</script>
@endpush