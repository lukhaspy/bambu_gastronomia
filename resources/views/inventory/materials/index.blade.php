@extends('layouts.app', ['page' => 'Materia Prima', 'pageSlug' => 'materials', 'section' => 'inventory'])
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">Materias Primas</h4>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('materials.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
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
                                <th scope="col">Stock Reservado</th>
                                <th scope="col">Total Vendidos</th>
                                <th scope="col"></th>
                            </thead>
                            <tbody>
                                @foreach ($products as $material)
                                    <tr>
                                        <td><a href="{{ route('categories.show', $material->category) }}">{{ $material->category->name }}</a></td>
                                        <td>{{ $material->name }}</td>
                                        <td>{{ format_money($material->price) }}</td>
                                        <td>{{ $material->stock }}</td>
                                        <td>{{ $material->reserved_stock }}</td>
                                        <td>{{ $material->solds->sum('qty') }}</td>
                                        <td class="td-actions text-right">
                                            <a href="{{ route('materials.show', $material) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Más detalles">
                                                <i class="tim-icons icon-zoom-split"></i>
                                            </a>
                                            <a href="{{ route('materials.edit', $material) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Editar materia prima">
                                                <i class="tim-icons icon-pencil"></i>
                                            </a>
                                            {!! Form::open(['route' => ['materials.destroy', $material], 'method' => 'delete', 'class' => 'd-inline']) !!}
                                                <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Eliminar materia prima" onclick="confirm('Estás seguro de querer eliminar esta materia prima? Los registros seguiran existiendo.') ? this.parentElement.submit() : ''">
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
