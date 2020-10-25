<tr>
    <td class="text-center numeracion">{{$key}}</td>
    <td class="ingrediente">
        {!! Form::select("materials[$key][material_id]", $materials, isset($item)? $item->material_id: null, ['class' => 'form-select form-control-alternative', 'required', 'placeholder' => 'Seleccione un ingrediente']) !!}
    </td>
    <td><span>Gs </span><span class="price"></span></td>
    <td class="stock"></td>
    <td class="unity"></td>
    <td>{!! Form::number("materials[$key][quantity]", isset($item)? $item->quantity: null, ['class' => 'form-control form-control-alternative', 'required', 'min' => 0]) !!}</td>
    <td class="td-actions text-right">
        <button type="button" rel="tooltip" class="btn btn-danger btn-link btn-icon btn-sm btremove" title="Eliminar Materia prima">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
        {!! Form::hidden("materials[$key][id]", isset($item)? $item->id: 'new') !!}
    </td>
</tr>
