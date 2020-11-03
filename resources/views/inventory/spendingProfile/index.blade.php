@extends('layouts.app', ['page' => 'Lista de Perfiles de Producción', 'pageSlug' => 'spendingProfiles', 'section' => 'inventory'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Perfiles de Producción</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('spendingProfiles.create') }}" class="btn btn-sm btn-primary">Nuevo</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('alerts.success')

                <div class="table-responsive">
                    <table class="table tablesorter" id="">
                        <thead class=" text-primary">
                            <th scope="col">Nombre</th>

                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            @foreach ($spendingProfiles as $spendingProfile)
                            <tr>
                                <td>{{ $spendingProfile->name }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ route('spendingProfiles.show', $spendingProfile) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="More Details">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </a>
                                    <a href="{{ route('spendingProfiles.edit', $spendingProfile) }}" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Edit spendingProfile">
                                        <i class="tim-icons icon-pencil"></i>
                                    </a>
                                    <form action="{{ route('spendingProfiles.destroy', $spendingProfile) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-link" data-toggle="tooltip" data-placement="bottom" title="Delete spendingProfile" onclick="confirm('Tenes certeza de eliminar ese perfil? Todas las operaciones registradas con el mismo seran eliminados.') ? this.parentElement.submit() : ''">
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
                    {{ $spendingProfiles->links() }}
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection