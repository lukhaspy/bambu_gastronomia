@extends('layouts.app', ['page' => 'Categoría', 'pageSlug' => 'categories', 'section' => 'inventory'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Categorías</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('alerts.success')

                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                        <th scope="col">Nombre</th>
                        <th scope="col">Productos</th>
                        <th scope="col">Total Stock</th>
                        <th scope="col">Precio Promedio</th>

                        <th scope="col"></th>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ count($category->products) }}</td>
                                <td>{{ $category->products->sum('stock') }}</td>
                                <td>{{ format_money($category->products->avg('price')) }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ route('categories.show', $category) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </a>
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Category">
                                        <i class="tim-icons icon-pencil"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Category" onclick="confirm('Tenes certeza de eliminar esa categoria? Todos los productos registrados con la misma seran eliminados.') ? this.parentElement.submit() : ''">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $categories->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
