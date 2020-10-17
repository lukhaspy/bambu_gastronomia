@extends('layouts.app', ['page' => 'Métodos', 'pageSlug' => 'methods', 'section' => 'methods'])

@section('content')
@include('alerts.success')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Ctas. de Banco / Métodos de Pago</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('methods.create') }}" class="btn btn-sm btn-primary">Nuevo Método</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="">
                    <table class="table tablesorter table-responsive" " id="">
                        <thead class=" text-primary">
                        <th scope="col">Método</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Transacciones Mensuales</th>
                        <th scope="col">Saldo Mensual</th>
                        <th scope="col"></th>
                        </thead>
                        <tbody>
                            @foreach ($methods as $method)
                            <tr>
                                <td>{{ $method->name }}</td>
                                <td>{{ $method->description }}</td>
                                <td>{{ $method->transactions->count() }}</td>
                                <td>{{ format_money($method->transactions->sum('amount')) }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ route('methods.show', $method) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </a>
                                    <a href="{{ route('methods.edit', $method) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Method">
                                        <i class="tim-icons icon-pencil"></i>
                                    </a>
                                    <form action="{{ route('methods.destroy', $method) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Method" onclick="confirm('Tenes certeza de eliminar ese metodo? Los datos de pagamento no seran eliminados.') ? this.parentElement.submit() : ''">
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
                    {{ $methods->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection