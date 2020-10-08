@extends('layouts.app', ['page' => 'Editar Cliente', 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Editar Cliente</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('clients.index') }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('clients.update', $client) }}" autocomplete="off">
                        @csrf
                        @method('put')

                        <h6 class="heading-small text-muted mb-4">Info del Cliente</h6>
                        <div class="pl-lg-4">
                            @if($errors->any())

                            <div class="badge badge-pill bg-danger text-white mb-3">
                                {!! implode('', $errors->all('<div><i class="tim-icons icon-simple-remove"></i> :message</div>')) !!}
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-4 form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">Nombre</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', $client->name) }}" required autofocus>
                                    @include('alerts.feedback', ['field' => 'name'])
                                </div>
                                <div class="col-md-8 form-group{{ $errors->has('surname') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-surname">Apellidos</label>
                                    <input type="text" name="surname" id="input-surname" class="form-control form-control-alternative{{ $errors->has('surname') ? ' is-invalid' : '' }}" value="{{ old('surname', $client->surname) }}">
                                    @include('alerts.feedback', ['field' => 'surname'])
                                </div>

                                <div class="col-md-3 form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-phone">Teléfono</label>
                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone', $client->phone) }}" required>
                                    @include('alerts.feedback', ['field' => 'phone'])
                                </div>
                                <div class="col-md-5 form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-address">Dirección</label>
                                    <input type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address', $client->address) }}" required>
                                    @include('alerts.feedback', ['field' => 'address'])
                                </div>
                                <div class="col-md-4 form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">Correo</label>
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', $client->email) }}">
                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-6 col-md-2 form-group{{ $errors->has('genre') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-document_type">Género</label>
                                    <select name="genre" id="input-genre" class="form-control form-control-alternative{{ $errors->has('genre') ? ' is-invalid' : '' }}" required>
                                        @foreach (['M', 'F', 'I'] as $genre)
                                        @if($genre == old('genre', $client->genre))
                                        <option value="{{$genre}}" selected>{{$genre}}</option>
                                        @else
                                        <option value="{{$genre}}">{{$genre}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 col-md-4 form-group{{ $errors->has('document_id') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-document_id">Cédula</label>
                                    <input type="number" name="document_id" id="input-document_id" class="form-control form-control-alternative{{ $errors->has('document_id') ? ' is-invalid' : '' }}" Number" value="{{ old('document_id', $client->document_id) }}">
                                    @include('alerts.feedback', ['field' => 'document_id'])

                                </div>
                                <div class="col-md-4 form-group{{ $errors->has('ruc') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-document_id">RUC</label>
                                    <input type="number" name="ruc" id="input-ruc" class="form-control form-control-alternative{{ $errors->has('ruc') ? ' is-invalid' : '' }}" Number" value="{{ old('ruc', $client->ruc) }}">
                                    @include('alerts.feedback', ['field' => 'ruc'])

                                </div>
                                <div class="col-md-3 form-group{{ $errors->has('birth') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-document_id">Nacimiento</label>
                                    <input type="date" name="birth" id="input-birth" class="form-control form-control-alternative{{ $errors->has('birth') ? ' is-invalid' : '' }}" Number" value="{{ old('birth', $client->birth) }}">
                                    @include('alerts.feedback', ['field' => 'birth'])

                                </div>
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