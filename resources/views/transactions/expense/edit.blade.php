@extends('layouts.app', ['page' => 'Gasto', 'pageSlug' => 'expenses', 'section' => 'transactions'])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Editar Gasto</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('transactions.type', ['type' => 'expense']) }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    <form method="post" action="{{ route('transactions.update', $transaction) }}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input type="hidden" name="type" value="{{ $transaction->type }}">
                        <input type="hidden" name="user_id" value="{{ $transaction->user_id }}">
                        <h6 class="heading-small text-muted mb-4">Info del Gasto</h6>
                        <div class="row">
                        <div class="form-group{{ $errors->has('spendingProfile_id') ? ' has-danger' : '' }} col-md-4">
                                <label class="form-control-label" for="input-spendingProfile">Perfil Gasto</label>
                                <select name="spendingProfile_id" id="input-spendingProfile" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}">
                                    @foreach ($spendingProfiles as $spendingProfile)
                                    @if($spendingProfile['id'] == old('spendingProfile_id')  or $spendingProfile['id'] == $transaction->spendingProfile_id )
                                    <option value="{{$spendingProfile['id']}}" selected>{{$spendingProfile['name']}}</option>
                                    @elseif(isset($_GET['spendingProfile_id']) && $spendingProfile['id'] == $_GET['spendingProfile_id'])
                                    <option value="{{$spendingProfile['id']}}" selected>{{$spendingProfile['name']}}</option>
                                    @else
                                    <option value="{{$spendingProfile['id']}}">{{$spendingProfile['name']}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'spendingProfile_id'])
                            </div>

                            <div class="form-group{{ $errors->has('payment_method_id') ? ' has-danger' : '' }} col-md-2">
                                <label class="form-control-label" for="input-method">Método</label>
                                <select name="payment_method_id" id="input-method" class="form-select2 form-control-alternative{{ $errors->has('payment_method_id') ? ' is-invalid' : '' }}" required>
                                    @foreach ($payment_methods as $payment_method)
                                    @if($payment_method['id'] == old('payment_method_id') or $payment_method['id'] == $transaction->payment_method_id)
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
                                <input type="number" step=".01" name="amount" id="input-amount" class="form-control form-control-alternative" value="{{ old('amount', abs($transaction->amount)) }}" min="0" required>
                                @include('alerts.feedback', ['field' => 'amount'])
                            </div>

                            <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }} col-md-5">
                                <label class="form-control-label" for="input-reference">Referencia</label>
                                <input type="text" name="reference" id="input-reference" class="form-control form-control-alternative{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ old('reference', $transaction->reference) }}">
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