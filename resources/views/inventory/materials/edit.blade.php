@extends('layouts.app', ['page' => 'Materia Prima', 'pageSlug' => 'materials', 'section' => 'inventory'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar Materia Prima</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('materials.index') }}" class="btn btn-sm btn-primary">Volver</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif
                        {!! Form::model($material, ['route' => ['materials.update', $material],'autocomplete' => 'off', 'method' => 'put']) !!}
                            @include('inventory.materials._forms')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        new SlimSelect({
            select: '.form-select'
        })
        new SlimSelect({
            select: '.form-select2'
        })
    </script>
@endpush
