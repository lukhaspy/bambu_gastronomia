@extends('layouts.app', ['page' => 'Pago', 'pageSlug' => 'payments', 'section' => 'transactions'])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Nuevo Pago</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('transactions.type', ['type' => 'payment']) }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    <form method="post" action="{{ route('transactions.store') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="type" value="payment">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <h6 class="heading-small text-muted mb-4">Info de Pago</h6>
                        <div class="row">
                            <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }} col-md-5">
                                <label class="form-control-label" for="input-title">Titulo</label>
                                <input type="text" name="title" id="input-title" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" required autofocus>
                                @include('alerts.feedback', ['field' => 'title'])
                            </div>


                            <div class="form-group{{ $errors->has('provider_id') ? ' has-danger' : '' }} col-md-3">
                                <label class="form-control-label" for="input-provider">Proveedor</label>
                                <select name="provider_id" id="input-provider" class="form-select form-control-alternative{{ $errors->has('provider_id') ? ' is-invalid' : '' }}" >
                                    @foreach ($providers as $provider)
                                    @if($provider['id'] == old('provider'))
                                    <option value="{{$provider['id']}}" selected>{{$provider['name']}}</option>
                                    @else
                                    <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'provider_id'])
                            </div>

                            <div class="form-group{{ $errors->has('payment_method_id') ? ' has-danger' : '' }} col-md-2">
                                <label class="form-control-label" for="input-method">Método</label>
                                <select name="payment_method_id" id="input-method" class="form-select2 form-control-alternative{{ $errors->has('payment_method_id') ? ' is-invalid' : '' }}" required>
                                    @foreach ($payment_methods as $payment_method)
                                    @if($payment_method['id'] == old('payment_method_id'))
                                    <option value="{{$payment_method['id']}}" selected>{{$payment_method['name']}}</option>
                                    @else
                                    <option value="{{$payment_method['id']}}">{{$payment_method['name']}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'payment_method_id'])
                            </div>

                            <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }} col-md-3">
                                <label class="form-control-label" for="input-amount">Monto</label>
                                <input type="number" step=".01" name="amount" id="input-amount" class="form-control form-control-alternative" Amount" value="{{ old('amount') }}" min="0" required>
                                @include('alerts.feedback', ['field' => 'amount'])

                            </div>

                            <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }} col-md-5">
                                <label class="form-control-label" for="input-reference">Referencia</label>
                                <input type="text" name="reference" id="input-reference" class="form-control form-control-alternative{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference') }}">
                                @include('alerts.feedback', ['field' => 'reference'])
                            </div>

                        </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Guardar</button>
                            </div>
                    </form>
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
@endpush('js')