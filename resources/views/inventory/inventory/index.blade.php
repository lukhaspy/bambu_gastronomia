@extends('layouts.app', ['page' => 'Inventario', 'pageSlug' => 'inventory', 'section' => 'inventory'])
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Inventarios</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('inventory.inventory.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('inventory.inventory.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="">Desde</label>
                            <input type="date" name="desde" value="{{$filters['desde'] ?? date('Y-m-d', strtotime('-7 days'))}}" class="form-control">

                        </div>
                        <div class="col-md-2">
                            <label for="">Hasta</label>
                            <input type="date" name="hasta" value="{{ $filters['hasta'] ?? date('Y-m-d')}}" class="form-control">

                        </div>
                        <div class="col-md-2">
                            <label for="" class="control-label">Buscar</label> <br>
                            <button type="submit" class="btn btn-block"><i class="tim-icons icon-lock-circle"></i></button>
                        </div>
                    </div>
                </form>

                @include('alerts.success')
                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class=" text-primary">
                            <th scope="col">Fecha</th>
                            <th scope="col">Operador</th>
                            <th scope="col">Productos</th>
                            <th scope="col">Costo Min, Ing. / Eg.</th>
                            <th scope="col">Costo Prom, Ing. / Eg.</th>
                            <th scope="col">Costo Max, Ing. / Eg.</th>
                            <th scope="col">Observación</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>

                            @foreach ($inventories as $inventory)

                            <tr>
                                <td>{{ date('d/m/Y H:i', strtotime($inventory->created_at)) }}</td>
                                <td>{{ $inventory->user->name }}</td>
                                <td>{{ $inventory->details->count() }}</td>

                                <td><span class=" badge @if($inventory->details->sum('sumMin') > 0)  badge-success @else badge-danger @endif" style="font-size: 1.2rem;">Gs. {{ number_format($inventory->details->sum('sumMin'), 0, '', '.') }} @if($inventory->details->sum('sumMin') > 0) <i class="tim-icons icon-simple-add"></i> @else <i class="tim-icons icon-minimal-down"></i> @endif</span></td>
                                <td><span class=" badge @if($inventory->details->sum('sumAvg') > 0)  badge-success @else badge-danger @endif" style="font-size: 1.2rem;">Gs. {{ number_format($inventory->details->sum('sumAvg'), 0, '', '.') }} @if($inventory->details->sum('sumAvg') > 0) <i class="tim-icons icon-simple-add"></i> @else <i class="tim-icons icon-minimal-down"></i> @endif</span></td>
                                <td><span class=" badge @if($inventory->details->sum('sumMax') > 0)  badge-success @else badge-danger @endif" style="font-size: 1.2rem;">Gs. {{ number_format($inventory->details->sum('sumMax'), 0, '', '.') }} @if($inventory->details->sum('sumMax') > 0) <i class="tim-icons icon-simple-add"></i> @else <i class="tim-icons icon-minimal-down"></i> @endif</span></td>

                                <td>{{ $inventory->observations }}</td>


                                <td class="td-actions text-right">

                                    <a href="{{ route('inventory.inventory.show', $inventory) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Más detalles">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </a>


                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end"> @if(isset($filters)) {!! $inventories->appends($filters)->links() !!} @else {!!$inventories->links()!!} @endif </nav>
            </div>
        </div>
    </div>
</div>
@endsection