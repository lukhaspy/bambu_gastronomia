<h6 class="heading-small text-muted mb-4">Información del Producto</h6>

<div class="row">
    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }} col-md-7">
        <label class="form-control-label" for="input-name">Nombre</label>
        {!! Form::text('name', null, ['class' => 'form-control form-control-alternative '.($errors->has('name') ? 'is-invalid' : ''), 'placeholder' => 'Nombre', 'required', 'autofocus']) !!}
        @include('alerts.feedback', ['field' => 'name'])
    </div>

    <div class="form-group{{ $errors->has('product_category_id') ? ' has-danger' : '' }} col-md-3">
        <label class="form-control-label" for="input-name">Categoría</label>
        {!! Form::select('product_category_id', $categories, null, ['class' => 'form-select form-control-alternative', 'placeholder' => 'Seleccione una categoría']) !!}
        @include('alerts.feedback', ['field' => 'product_category_id'])
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }} col-md-5">
        <label class="form-control-label" for="input-description">Descripción</label>
        {!! Form::text('description', null, ['class' => 'form-control form-control-alternative', 'placeholder' => 'Descripción', 'required']) !!}
        @include('alerts.feedback', ['field' => 'description'])
    </div>
            <div class="form-group{{ $errors->has('unity') ? ' has-danger' : '' }} col-md-2">
                <label class="form-control-label" for="input-unity">Medida (No puede ser actualizada)</label>
                {!! Form::select('unity', getUnities(), null, ['class' => 'form-select2 form-control-alternative']) !!}
                @include('alerts.feedback', ['field' => 'unity'])
            </div>
           
            <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }} col-md-3">
                <label class="form-control-label" for="input-price">Precio</label>
                {!! Form::number('price', null, ['class' => 'form-control form-control-alternative', 'required']) !!}
                @include('alerts.feedback', ['field' => 'price'])
            </div>
            <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }} col-md-2">
                <label class="form-control-label" for="input-stock">Stock</label>
                {!! Form::number('stock', isset($production)? null : 0, ['class' => 'form-control form-control-alternative', 'readonly']) !!}
                @include('alerts.feedback', ['field' => 'stock'])
            </div>
</div>

<h6 class="heading-small text-muted mb-4">Materias Primas</h6>
<div class="table-responsive">
    <table class="table table-border table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Materia Prima</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Medida</th>
                <th>Cantidad a Utilizar</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @isset($production)
            @foreach ($production->materials as $key => $item)
            @include('inventory.production._materials', ['key' => $key +1, 'materials' => $materials->pluck('name','id'),'item' => $item])
            @endforeach
            @else
            @include('inventory.production._materials', ['key' => 1, 'materials' => $materials->pluck('name','id')])
            @include('inventory.production._materials', ['key' => 2, 'materials' => $materials->pluck('name','id')])
            @include('inventory.production._materials', ['key' => 3, 'materials' => $materials->pluck('name','id')])
            @endif
        </tbody>
    </table>
</div>
<div class="row align-items-start">
    <div class="col-4">
        <button class="btn btn-sm btn-primary addMat" type="button">Agregar otro ingrediente</a>
    </div>
</div>

<div class="text-center">
    <button type="submit" class="btn btn-success mt-4">Guardar</button>
</div>

@push('js')
<script>
    const materials = {!!$materials->toJson() !!}
    @isset($production)
    var count = 
        {{
            $production-> materials-> count() + 1
        }}
    
    fillTable()
    @else
    var count = 4
    @endif

    $('.addMat').on('click', function(e) {
        e.preventDefault();

        var table = $('.table')
        console.log("/inventory/production/materials/" + count)
        $.ajax({
            type: "GET",
            url: "/inventory/production/materials/" + count,
            success: function(response) {
                table.find('tbody').append(response.html)
                count++
            }
        });
    })

    $('table').on('click', '.btremove', function(e) {
        e.preventDefault();
        const btn = $(this)
        const input = btn.siblings()
        if (input.val() != 'new') {
            if (confirm('Estás seguro de querer eliminar? Se eliminará permanente aunque abandone la pagina sin guardar. Esto es irreversible.')) {
                $.ajax({
                    type: "GET",
                    url: "/inventory/production/materials/" + input.val() + '/delete',
                    success: function(response) {
                        $(input).closest('tr').remove()
                    },
                    error: function(response) {
                        console.log('error', response.responseJSON)
                    }
                });
            }
        } else {
            $(this).closest('tr').remove()
        }
    })

    $('table').on('change', '.ingrediente select', function(e) {
        var select = $(this)
        var id = this.value
        const material = materials.find(element => element.id == id)
        const tr = select.closest('tr')
        fillTr(material, tr)
    })

    function fillTable() {
        const table = $('table')
        var row = table.find('tr')
        table.find('tbody tr').each(function(index, element) {
            let me = $(element)
            let select = me.find('td.ingrediente select')
            const material = materials.find(element => element.id == select.val())
            fillTr(material, me)

        });
    }

    function fillTr(material, tr) {
        tr.find('td span.price').html(material.price)
        tr.find('td.stock').html(material.stock)
        tr.find('td.unity').html(getUnityValue(material.unity))
    }

    function getUnityValue(id) {
        var text = '';
        switch (id) {
            case 0:
                text = 'Unitario'
                break;
            case 1:
                text = 'Gramos'
                break;
            case 2:
                text = 'Kilogramos'
                break;
            case 3:
                text = 'Mililitro'
                break;
            case 4:
                text = 'Litros'
                break;
        }

        return text
    }
</script>
@endpush