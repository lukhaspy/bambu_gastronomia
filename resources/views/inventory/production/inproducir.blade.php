@extends('layouts.app', ['page' => "Revertir $production->name", 'pageSlug'  => 'production', 'section' => 'inventory'])

@section('content')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Revertir {{$production->name}}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('production.index') }}" class="btn btn-sm btn-primary">Volver</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! Form::model($production, ['route' => ['production.inMake', $production],'autocomplete' => 'off', 'method' => 'post']) !!}
                            <h6 class="heading-small text-muted mb-4">Información del Producto</h6>
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">Name</label>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre', 'readonly']) !!}
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="input-description">Descripción</label>
                                    {!! Form::text('description', null, ['class' => 'form-control form-control-alternative', 'placeholder' => 'Descripción', 'readonly']) !!}
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-unity">Medida</label>
                                            {!! Form::select('unity', getUnities(), null, ['class' => 'form-select form-control-alternative', 'disabled']) !!}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-stock">Stock</label>
                                            {!! Form::number('stock', null, ['class' => 'form-control form-control-alternative', 'required', 'min' => 0, 'max' => $production->stock]) !!}
                                            @include('alerts.feedback', ['field' => 'stock'])
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-price">Precio</label>
                                            {!! Form::number('price', null, ['class' => 'form-control form-control-alternative', 'readOnly']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="heading-small text-muted mb-4">Ingredientes</h6>
                            <div class="col-12 altDan"></div>
                            <div class="table-responsive">
                                <table class="table table-border table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Materia Prima</th>
                                            <th>Precio</th>
                                            <th>Stock</th>
                                            <th>Stock Reservado</th>
                                            <th>Cantidad Por unidad</th>
                                            <th>Medida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($production->materials as $key => $mat)
                                            <tr>
                                                <td class="text-center numeracion">{{$key + 1}}</td>
                                                <td class="ingrediente">{{$mat->material->name}}</td>
                                                <td><span>Gs </span><span class="price">{{$mat->material->price}}</span></td>
                                                <td class="stock text-success" data-original="{{$mat->material->stock}}">{{$mat->material->stock}}</td>
                                                <td><span class="reserved text-danger" data-original="{{$production->stock * $mat->quantity}}">{{$production->stock * $mat->quantity}}</span></td>
                                                <td><span class="qty">{{$mat->quantity}}</span></td>
                                                <td class="unity">{{getUnity($mat->material->unity)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {!! Form::hidden('ferror', null) !!}

                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Guardar</button>
                            </div>

                        {!! Form::close() !!}
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

        $('input[name=stock]').on('change', function(e){
            e.preventDefault();
            var input = $(this)
            var qty = input.val()
            var difference = input.attr('max') - qty

            $('table tbody tr').each(function (index, element) {
                let row = $(element)
                let stock = row.find('td.stock')
                let reserved = row.find('td .reserved')
                let reservar = row.find('td .qty')
                let valNew = Number(difference * reservar[0].textContent)
                stock.html(Number(stock.data('original')) + valNew)
                reserved.html(Number(reserved.data('original')) - valNew)
            });
        })
    </script>
@endpush
