@extends('layouts.app', ['page' => 'Materia Prima', 'pageSlug' => 'materials', 'section' => 'inventory'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Información de la Materia Prima</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>Precio Base</th>
                        <th>Precio Promedio</th>
                        <th>Total Vendido</th>
                        <th>Ingreso Generado</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $material->id }}</td>
                            <td><a href="{{ route('categories.show', $material->category) }}">{{ $material->category->name }}</a></td>
                            <td>{{ $material->name }}</td>
                            <td>{{ $material->stock }}</td>
                            <td>{{ format_money($material->price) }}</td>
                            <td>{{ format_money($material->solds->avg('price')) }}</td>
                            <td>{{ $material->solds->sum('qty') }}</td>
                            <td>{{ format_money($material->solds->sum('total_amount')) }}</td>
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
            <div class="card-body">
                <h4 class="card-title">Últimas Ventas</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <th>Fecha</th>
                        <th>ID</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Total</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($solds as $sold)
                        <tr>
                            <td>{{ date('d-m-y', strtotime($sold->created_at)) }}</td>
                            <td><a href="{{ route('sales.show', $sold->sale_id) }}">{{ $sold->sale_id }}</a></td>
                            <td>{{ $sold->qty }}</td>
                            <td>{{ format_money($sold->price) }}</td>
                            <td>{{ format_money($sold->total_amount) }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ route('sales.show', $sold->sale_id) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="View Sale">
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Últimas Compras</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <th>Fecha</th>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Stock</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($receiveds as $received)
                        <tr>
                            <td>{{ date('d-m-y', strtotime($received->created_at)) }}</td>
                            <td><a href="{{ route('receipts.show', $received->receipt) }}">{{ $received->receipt_id }}</a></td>
                            <td style="max-width:150px;">{{ $received->receipt->title }}</td>
                            <td>{{ $received->stock }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ route('receipts.show', $received->receipt) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Ver Receipt">
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
