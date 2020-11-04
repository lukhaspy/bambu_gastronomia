@extends('layouts.app', ['page' => 'Proveedor', 'pageSlug' => 'providers', 'section' => 'providers'])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Editar Proveedor</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('providers.index') }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    <form method="post" action="{{ route('providers.update', $provider) }}" autocomplete="off">
                        @csrf
                        @method('put')

                        <h6 class="heading-small text-muted mb-4">Datos</h6>
                        <div class="row">
                            <div class="form-group{{ $errors->has('ruc') ? ' has-danger' : '' }} col-md-3">
                                <label class="form-control-label" for="input-description">RUC *</label>
                                <input type="text" name="ruc" id="input-ruc" class="form-control form-control-alternative{{ $errors->has('ruc') ? ' is-invalid' : '' }}" value="{{ old('ruc', $provider->ruc) }}" required>
                                @include('alerts.feedback', ['field' => 'ruc'])
                            </div>
                            <div class="form-group{{ $errors->has('razon') ? ' has-danger' : '' }} col-md-5">
                                <label class="form-control-label" for="input-razon">Razón Social *</label>
                                <input type="text" name="razon" id="input-razon" class="form-control form-control-alternative{{ $errors->has('razon') ? ' is-invalid' : '' }}" value="{{ old('razon', $provider->razon) }}" required autofocus>
                                @include('alerts.feedback', ['field' => 'razon'])
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-md-5">
                                <label class="form-control-label" for="input-name">Nombre Común *</label>
                                <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', $provider->name) }}" required>
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }} col-md-5">
                                <label class="form-control-label" for="input-address">Dirección *</label>
                                <input type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address', $provider->address) }}" required>
                                @include('alerts.feedback', ['field' => 'address'])
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }} col-md-3">
                                <label class="form-control-label" for="input-phone">Teléfono *</label>
                                <input type="phone" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" .." value="{{ old('phone', $provider->phone) }}" required>
                                @include('alerts.feedback', ['field' => 'phone'])
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}  col-md-4">
                                <label class="form-control-label" for="input-email">Email</label>
                                <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', $provider->email) }}">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>


                            <div class="form-group{{ $errors->has('obs') ? ' has-danger' : '' }}  col-md-12">
                                <label class="form-control-label" for="input-obs">Observaciones</label>
                                <textarea name="obs" id="input-obs" class="form-control form-control-alternative{{ $errors->has('obs') ? ' is-invalid' : '' }}" value="{{ old('obs', $provider->obs) }}"></textarea>
                                @include('alerts.feedback', ['field' => 'obs'])
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection