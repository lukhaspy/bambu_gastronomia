@extends('layouts.app', ['page' => 'Lista de Funcionarios', 'pageSlug' => 'employees', 'section' => 'inventory'])
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Funcionarios</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">Agregar</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('alerts.success')
                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class=" text-primary">
                            <th scope="col">Documento</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Tel.</th>
                            <th scope="col">Nacimiento</th>
                            <th scope="col">Salario</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->document_id }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->surname }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ date('d-m-y', strtotime($employee->birth)) }}</td>

                                <td>{{ format_money($employee->salary) }}</td>

                                <td class="td-actions text-right">
                                    <a href="{{ route('employees.show', $employee) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Más detalles">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Editar Producto">
                                        <i class="tim-icons icon-pencil"></i>
                                    </a>
                                    {!! Form::open(['route' => ['employees.destroy', $employee], 'method' => 'delete', 'class' => 'd-inline']) !!}
                                    <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Eliminar Producto" onclick="confirm('Estás seguro de querer eliminar esta materia prima? Los registros seguiran existiendo.') ? this.parentElement.submit() : ''">
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
                <nav class="d-flex justify-content-end">{{ $employees->links() }}</nav>
            </div>
        </div>
    </div>
</div>
@endsection