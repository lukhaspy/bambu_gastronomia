@extends('layouts.app', ['page' => 'Sucursales', 'pageSlug' => 'branches', 'section' => 'branches'])
@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Nueva Sucursal</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('branches.index') }}" class="btn btn-sm btn-primary">Volver</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'branches.store','autocomplete' => 'off']) !!}
                            @include('branches._forms')
                        {!! Form::close() !!}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
