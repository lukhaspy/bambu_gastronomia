<h6 class="heading-small text-muted mb-4">Información del Producto</h6>

<div class="row">


    <div class="form-group{{ $errors->has('observations') ? ' has-danger' : '' }} col-md-5">
        <label class="form-control-label" for="input-observations">Descripción</label>
        {!! Form::text('observations', $inventory->observations ?? '', ['class' => 'form-control form-control-alternative', 'placeholder' => 'Descripción', 'nullable', (isset($inventory)) ? 'disabled' : '']) !!}
        @include('alerts.feedback', ['field' => 'observations'])
    </div>

</div>

<h6 class="heading-small text-muted mb-4">Productos</h6>
<div class="table-responsive">
    <table class="table table-border table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Producto</th>
                <th>Min Costo</th>
                <th>Max Costo</th>
                <th>Costo Promedio</th>
                <th>Stock</th>
                <th>Stock Real</th>
                <th>Costo Defecto</th>
            </tr>
        </thead>
        <tbody>
            @isset($inventory)
            @foreach ($inventory->details()->get() as $key => $item)
            @include('inventory.inventory._products', ['key' => $key +1, 'item' => $item])
            @endforeach
            @else
            @foreach($products as $key => $product)
            @include('inventory.inventory._products', ['key' => $key + 1])
            @endforeach
            @endif
        </tbody>
    </table>
</div>



@push('js')
<script>
    $('table').on('change', '.ingrediente select', function(e) {
        var select = $(this)
        var id = this.value
        const material = products.find(element => element.id == id)
        const tr = select.closest('tr')
        fillTr(material, tr)
    })

    function fillTable() {
        const table = $('table')
        var row = table.find('tr')
        table.find('tbody tr').each(function(index, element) {
            let me = $(element)
            let select = me.find('td.ingrediente select')
            const material = products.find(element => element.id == select.val())
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