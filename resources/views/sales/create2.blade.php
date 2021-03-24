@extends('layouts.app', ['page' => 'Venta', 'pageSlug' => 'sales-create', 'section' => 'transactions'])

@section('content')
<div class="container-fluid mt--7">
    @include('alerts.error')
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Nueva Venta</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif

                    <form method="post" action="{{ route('sales.store') }}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="pl-lg-4 col-12 col-md-4">
                                <label class="form-control-label" for="input-provider">Fecha</label>

                                <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="date">
                            </div>
                            <div class="pl-lg-4 col-12 col-md-4 ">
                                <div class="form-group{{ $errors->has('client_id') ? ' has-danger' : '' }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <label class="form-control-label" for="input-name">Cliente</label>
                                    <select name="client_id" id="input-category" class="form-select form-control-alternative{{ $errors->has('client') ? ' is-invalid' : '' }}">
                                        @foreach ($clients as $client)
                                        @if($client['id'] == old('client'))
                                        <option value="{{$client['id']}}" selected>{{$client['name']}} - {{$client['document_type'].$client['document_id']}}</option>
                                        @else
                                        <option value="{{$client['id']}}">{{$client['name']}} - {{$client['document_type'].$client['document_id']}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @include('alerts.feedback', ['field' => 'client_id'])
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