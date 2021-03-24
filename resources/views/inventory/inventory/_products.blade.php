<tr>
    {!! Form::hidden("products[$key][product_id]", $product->id ?? $item->product->id) !!}
    {!! Form::hidden("products[$key][old_quantity]", $product->stock ?? $item->product->stock) !!}

    <td class="text-center numeracion">{{$key}}</td>
    <td class="ingrediente">
        {!! Form::label($product->name ?? $item->product->name) !!}
    </td>

    <td><span>Gs </span><span class="price">{!! Form::label((isset($product) && $product->receiveds->count() > 0) ? number_format($product->receiveds[0]->min, 0, '', '.') : ((isset($item)) ? number_format($item->min_cost, 0, '', '.') : 0 )) !!}</span></td>
    <td><span>Gs </span><span class="price">{!! Form::label((isset($product) && $product->receiveds->count() > 0) ? number_format($product->receiveds[0]->max, 0, '', '.') : ((isset($item)) ? number_format($item->max_cost, 0, '', '.') : 0 )) !!}</span></td>
    <td><span>Gs </span><span class="price">{!! Form::label((isset($product) && $product->receiveds->count() > 0) ? number_format($product->receiveds[0]->avg, 0, '', '.') : ((isset($item)) ? number_format($item->avg_cost, 0, '', '.') : 0 )) !!}</span></td>

    <td class=""></span><span class="stock">{!! Form::label($product->stock ?? number_format($item->old_quantity, 0, '', '.')) !!}</span></td>
    <td>{!! Form::number("products[$key][new_quantity]", (isset($item)) ? number_format($item->new_quantity, 0, '', '.') : "0" , ['class' => 'form-control form-control-alternative', (isset($inventory)) ? 'disabled' : 'required', 'min' => 0]) !!}</td>
    <td>{!! Form::number("products[$key][default_cost]",(isset($item)) ? number_format($item->default_cost, 0, '', '.') : "0", ['class' => 'form-control form-control-alternative', (isset($inventory)) ? 'disabled' : 'required', 'min' => 0]) !!}</td>

</tr>