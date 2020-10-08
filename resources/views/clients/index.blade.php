@extends('layouts.app', ['page' => 'Clients', 'pageSlug' => 'clients', 'section' => 'clients'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Clientes</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('clients.create') }}" class="btn btn-sm btn-primary">Nuevo Cliente</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('alerts.success')

                <div class="">
                    <table class="table tablesorter " id="">
                        <thead class=" text-primary">
                            <th>Nombre y Cédula</th>

                            <th>Correo / Teléfono</th>
                            <th>Dirección</th>

                            <th>Saldo</th>
                            <th>Compras</th>
                            <th>Pagos Totales</th>
                            <th>Ult. Compra</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->name }}<br>{{ $client->surname }}-{{ $client->document_id }}</td>
                                <td>
                                    <a href="mailto:{{ $client->email }}">{{ $client->email }}</a>
                                    <br>
                                    {{ $client->phone }}
                                </td>
                                <td>{{$client->address}}</td>
                                <td>
                                    @if (round($client->balance) > 0)
                                    <span class="text-success">{{ format_money($client->balance) }}</span>
                                    @elseif (round($client->balance) < 0.00) <span class="text-danger">{{ format_money($client->balance) }}</span>
                                        @else
                                        {{ format_money($client->balance) }}
                                        @endif
                                </td>
                                <td>{{ $client->sales->count() }}</td>
                                <td>{{ format_money($client->transactions->sum('amount')) }}</td>
                                <td>{{ ($client->sales->sortByDesc('created_at')->first()) ? date('d-m-y', strtotime($client->sales->sortByDesc('created_at')->first()->created_at)) : 'N/A' }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ route('clients.show', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Ver">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </a>
                                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Editar">
                                        <i class="tim-icons icon-pencil"></i>
                                    </a>
                                    <form action="{{ route('clients.destroy', $client) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onclick="confirm('Estás seguro que quieres eliminar a este Client? Los registros de sus compras y Transactions no serán eliminados.') ? this.parentElement.submit() : ''">
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
                    {{ $clients->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection