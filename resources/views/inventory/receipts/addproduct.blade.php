@extends('layouts.app', ['page' => 'Producto', 'pageSlug' => 'receipt', 'section' => 'inventory'])

@section('content')
<div class="row">
    <div class="col-xl-12 order-xl-1">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Agregar Producto</h3>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('receipts.show', $receipt) }}" class="btn btn-sm btn-primary">Volver</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('receipts.product.store', $receipt) }}" autocomplete="off">
                    @csrf

                    <div class="pl-lg-4">
                        <input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
                        <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                            <label class="form-control-label" for="input-product">Producto</label>
                            <select name="product_id" id="input-product" class="form-select form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" required>
                                @foreach ($products as $product)

                                @if($product['id'] == old('product_id'))
                                <option value="{{$product['id']}}" selected>
                                    [{{ $product->category->name }}] | [{{getUnity($product->unity)}}] {{ $product->name }} - (Precio: {{format_money($product->price)}})
                                    @foreach($providerReceipts as $tmp)


                                    @if($tmp->product_id == $product['id'])
                                    @if($tmp->unity == 1)
                                    (kg) {{format_money($tmp->min * 1000)}} / {{format_money($tmp->max * 1000)}}
                                    @else
                                    {{format_money($tmp->min )}} / {{format_money($tmp->max )}}
                                    @endif
                                    @endif

                                    @endforeach
                                </option>

                                @else
                                <option value="{{$product['id']}}"> [{{ $product->category->name }}] | [{{getUnity($product->unity)}}] {{ $product->name }} - (Precio: {{format_money($product->price)}})

                                    @foreach($providerReceipts as $tmp)
                                    @if($tmp->product_id == $product['id'])
                                    @if($tmp->unity === 1)
                                    (kg) {{format_money($tmp->min * 1000)}} / {{format_money($tmp->max * 1000)}}
                                    @else
                                    {{format_money($tmp->min )}} / {{format_money($tmp->max )}}
                                    @endif
                                    @endif
                                    @endforeach
                                </option>
                                @endif
                                @endforeach
                            </select>
                            @include('alerts.feedback', ['field' => 'product_id'])
                        </div>
                        <div class="row">
                            <div class="form-group{{ $errors->has('qty') ? ' has-danger' : '' }} col-md-2">
                                <label class="form-control-label" for="input-qty">Cantidad</label>
                                <input type="number" name="qty" id="input-qty" class="form-control form-control-alternative{{ $errors->has('qty') ? ' is-invalid' : '' }}" value="0" required>
                                @include('alerts.feedback', ['field' => 'qty'])
                            </div>
                            <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }} col-md-3">
                                <label class="form-control-label" for="input-cost">Costo Unitario</label>
                                <input type="number" step="0.01" name="cost" id="input-cost" class="form-control form-control-alternative{{ $errors->has('cost') ? ' is-invalid' : '' }}" value="0" required>
                                @include('alerts.feedback', ['field' => 'cost'])
                            </div>
                            <div class="form-group{{ $errors->has('cost') ? ' has-danger' : '' }} col-md-3">
                                <label class="form-control-label" for="input-cost">Costo Total</label>
                                <input type="number" id="input-cost-total" class="form-control form-control-alternative" value="0">
                            </div>

                            <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }} col-md-3">
                                <label class="form-control-label" for="input-total">Total</label>
                                <input type="text" name="total_amount" id="input-total" class="form-control form-control-alternative{{ $errors->has('product_id') ? ' is-invalid' : '' }}" value="0 Gs" readonly>
                                @include('alerts.feedback', ['field' => 'product_id'])
                            </div>


                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">Continuar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    new SlimSelect({
        select: '.form-select'
    });
</script>

<script>
    let input_product = document.getElementById('input-product')
    let input_qty = document.getElementById('input-qty');
    let input_cost = document.getElementById('input-cost');
    let input_total = document.getElementById('input-total');
    let input_cost_total = document.getElementById('input-cost-total');

    input_product.addEventListener('change', updateCost);
    input_qty.addEventListener('input', updateCostTotal);
    input_cost.addEventListener('input', updateTotal);
    input_cost_total.addEventListener('input', updateCostTotal);

    input_cost.value = $('#input-product-cost-' + $('#input-product').val()).val()



    function updateCostTotal() {
        input_cost.value = parseFloat(parseFloat(input_cost_total.value) / parseInt(input_qty.value)).toFixed(2)
        input_total.value = (parseInt(input_qty.value) * parseFloat(input_cost.value)) + " Gs";
    }

    function updateCost() {
        input_cost.value = $('#input-product-cost-' + $('#input-product').val()).val()
    }

    function updateTotal() {
        input_cost_total.value = 0
        input_total.value = (parseInt(input_qty.value) * parseFloat(input_cost.value)) + " Gs";

    }
</script>
@endpush