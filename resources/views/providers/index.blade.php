@extends('layouts.app', ['page' => 'Lista de Proveedores', 'pageSlug' => 'providers', 'section' => 'providers'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Proveedores</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('providers.create') }}" class="btn btn-sm btn-primary">Nuevo Proveedor</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('alerts.success')

                <div class="">
                    <table class="table tablesorter " id="">
                        <thead class=" text-primary">
                            <th scope="col">RUC</th>
                            <th scope="col">Razón Social</th>
                            <th scope="col">Nombre Común</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Email</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Observaciones</th>
                            <th scope="col">Pagos</th>
                        </thead>
                        <tbody>
                            @foreach ($providers as $provider)
                            <tr class="{{ ($provider->deleted_at) ? 'bg-danger':'' }}">
                                <td>{{ $provider->ruc }}</td>
                                <td>{{ $provider->razon }}</td>

                                <td>{{ $provider->name }}</td>
                                <td>{{ $provider->address }}</td>

                                <td>
                                    <a href="mailto:{{ $provider->email }}">{{ $provider->email }}</a>
                                </td>
                                <td>{{ $provider->phone }}</td>
                                <td>{{ $provider->obs }}</td>

                                <td>{{ format_money(abs($provider->transactions->sum('amount'))) }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ route('providers.show', $provider) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </a>
                                    <a href="{{ route('providers.edit', $provider) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit Provider">
                                        <i class="tim-icons icon-pencil"></i>
                                    </a>
                                    <form action="{{ route('providers.destroy', $provider) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete Provider" onclick="confirm('Are you sure you want to delete this provider? Records of payments made to him will not be deleted.') ? this.parentElement.submit() : ''">
                                            <i class="tim-icons icon-simple-remove"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $providers->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection