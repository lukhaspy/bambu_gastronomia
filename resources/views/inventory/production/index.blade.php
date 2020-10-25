@extends('layouts.app', ['page' => 'Lista de Producciones', 'pageSlug' => 'production', 'section' => 'inventory'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Producciones</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('production.create') }}" class="btn btn-sm btn-primary">Agregar Producción</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('alerts.success')
                    <div class="table-responsive">
                        <table class="table tablesorter">
                            <thead class=" text-primary">
                                <th scope="col">Categoría</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Precio Base</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Total Vendidos</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($products as $production)
                                    <tr>
                                        <td><a href="{{ route('categories.show', $production->category) }}">{{ $production->category->name }}</a></td>
                                        <td>{{ $production->name }}</td>
                                        <td>{{ format_money($production->price) }}</td>
                                        <td>{{ $production->stock }}</td>
                                        <td>{{ $production->solds->sum('qty') }}</td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('production.producir', $production) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Aumentar Stock">
                                                <i class="tim-icons icon-simple-add"></i>
                                            </a>
                                            <a href="{{ route('production.inProducir', $production) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Disminuir Stock">
                                                <i class="tim-icons icon-simple-add"></i>
                                            </a>
                                            <a href="{{ route('production.show', $production) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Más detalles">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('production.edit', $production) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Editar Producción">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            {!! Form::open(['route' => ['production.destroy', $production], 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Eliminar Producción" onclick="confirm('Estás seguro de querer eliminar esta Producción? Los registros seguiran existiendo.') ? this.parentElement.submit() : ''">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end">{{ $products->links() }}</nav>
                </div>
            </div>
        </div>
    </div>
@endsection
