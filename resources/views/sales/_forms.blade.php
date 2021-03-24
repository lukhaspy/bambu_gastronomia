<h6 class="heading-small text-muted mb-4">Información de la Venta</h6>

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
       
    </div>
</div>

<h6 class="heading-small text-muted mb-4">Productos</h6>
<div class="table-responsive">
    <table class="table table-border table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Medida</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @isset($sale)
            @foreach ($sale->products as $key => $item)
            @include('sales._products', ['key' => $key +1, 'products' => $products->pluck('name','id'),'item' => $item])
            @endforeach
            @else
            @include('sales._products', ['key' => 1, 'products' => $products->pluck('name', 'id')])
            @include('sales._products', ['key' => 2, 'products' => $products->pluck('name', 'id')])
            @include('sales._products', ['key' => 3, 'products' => $products->pluck('name', 'id')])
            @endif
        </tbody>
    </table>
</div>
<div class="row align-items-start">
    <div class="col-4">
        <button class="btn btn-sm btn-primary addMat" type="button">Agregar otro producto</a>
    </div>
</div>

<div class="text-center">
<hr>
    <button type="submit" class="btn btn-success">Guardar</button>
</div>

@push('js')
<script>
    const products = {!!$products->toJson() !!}
    @isset($production)
    var count = 
        {{
            $production-> products-> count() + 1
        }}
    
    fillTable()
    @else
    var count = 4
    @endif

    $('.addMat').on('click', function(e) {
        e.preventDefault();

        var table = $('.table')
        console.log("/inventory/product/table/" + count)
        $.ajax({
            type: "GET",
            url: "/inventory/product/table/" + count,
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
                    url: "/inventory/production/products/" + input.val() + '/delete',
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
       tr.find('td input.price').val(material.price)
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