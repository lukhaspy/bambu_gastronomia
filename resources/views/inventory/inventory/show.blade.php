@extends('layouts.app', ['page' => 'Inventario', 'pageSlug' => 'inventory.inventory', 'section' => 'inventory'])

@section('content')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Inventario {{date('d/m/Y H:i', strtotime($inventory->created_at))}}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('inventory.inventory.index') }}" class="btn btn-sm btn-primary">Volver</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @endif
                    @include('inventory.inventory._forms')
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