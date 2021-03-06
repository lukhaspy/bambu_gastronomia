@extends('layouts.app', ['page' => 'Usuario', 'pageSlug' => 'users', 'section' => 'users'])
@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Editar Usuario</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">Volver</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! Form::model($user, ['route' => ['users.update', $user], 'autocomplete' => 'off', 'method' => 'put']) !!}
                            @include('users._forms')
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
    </script>
@endpush
