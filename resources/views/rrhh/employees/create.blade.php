@extends('layouts.app', ['page' => 'Funcionario', 'pageSlug' => 'employees', 'section' => 'inventory'])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Nuevo Funcionario</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('materials.index') }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['route' => 'employees.store','autocomplete' => 'off']) !!}
                    @include('rrhh.employees._forms')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection