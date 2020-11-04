@extends('layouts.app', ['page' => 'Compra', 'pageSlug' => 'receipts', 'section' => 'inventory'])

@section('content')
<div class="container-fluid mt--7">
    @include('alerts.error')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Nueva Compra</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('receipts.index') }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    <form method="post" action="{{ route('receipts.store') }}" autocomplete="off">
                        @csrf

                        <h6 class="heading-small text-muted mb-4">Info de la Compra</h6>

                        <div class="row">
                            <div class="pl-lg-4 col-12 col-md-4">
                                <label class="form-control-label" for="input-provider">Fecha</label>

                                <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="date">
                            </div>
                            <div class="pl-lg-4 col-12 col-md-4">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">



                                <div class="form-group{{ $errors->has('provider_id') ? ' has-danger' : '' }} ">
                                    <label class="form-control-label" for="input-provider">Proveedor</label>
                                    <select name="provider_id" id="input-provider"  class="form-select  form-control-alternative{{ $errors->has('provider') ? ' is-invalid' : '' }}">
                                        @foreach ($providers as $provider)
                                        @if($provider['id'] == old('provider_id'))
                                        <option value="{{$provider['id']}}" selected>{{$provider['name']}}</option>
                                        @else
                                        <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'provider_id'])
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">Continuar</button>
                                </div>
                            </div>
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
</script>
@endpush