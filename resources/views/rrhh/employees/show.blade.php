@extends('layouts.app', ['page' => 'Funcionario', 'pageSlug' => 'employees', 'section' => 'inventory'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Información del Funcionario</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
                        <th scope="col">Documento</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Tel.</th>
                        <th scope="col">Nacimiento</th>
                        <th scope="col">Salario</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $employee->document_id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->surname }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ date('d-m-y', strtotime($employee->birth)) }}</td>

                            <td>{{ format_money($employee->salary) }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection