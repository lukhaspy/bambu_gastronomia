@extends('layouts.app', ['page' => 'Sucursales', 'pageSlug' => 'branches', 'section' => 'branches'])
@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar Sucursal</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('branches.index') }}" class="btn btn-sm btn-primary">Volver</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::model($branch, ['route' => ['branches.update', $branch], 'autocomplete' => 'off', 'method' => 'put']) !!}
                            @include('branches._forms')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
