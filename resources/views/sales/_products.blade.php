<tr>
    <td class="text-center numeracion">{{$key}}</td>
    <td class="ingrediente">
        {!! Form::select("products[$key][product_id]", $products, isset($item)? $item->product_id: null, ['class' => 'form-select form-control-alternative', 'required', 'placeholder' => 'Seleccione un producto']) !!}
    </td>
    <td><span>Gs </span><span class="price"></span></td>
    <td class="stock"></td>
    <td class="unity"></td>
    <td>{!! Form::number("products[$key][qty]", isset($item)? $item->quantity: 1, ['class' => 'form-control form-control-alternative', 'required', 'min' => 0]) !!}</td>
    <td>{!! Form::number("products[$key][price]", isset($item)? $item->price: null, ['class' => 'form-control form-control-alternative price', 'required', 'min' => 0]) !!}</td>

    <td class="td-actions text-right">
        <button type="button" rel="tooltip" class="btn btn-danger btn-link btn-icon btn-sm btremove" title="Eliminar Materia prima">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
        {!! Form::hidden("products[$key][id]", isset($item)? $item->id: 'new') !!}
    </td>
</tr>
