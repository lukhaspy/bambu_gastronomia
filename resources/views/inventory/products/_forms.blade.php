<h6 class="heading-small text-muted mb-4">Información del Producto</h6>
<div class="pl-lg-4">
    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-name">Name</label>
        {!! Form::text('name', null, ['class' => 'form-control form-control-alternative '.($errors->has('name') ? 'is-invalid' : ''), 'placeholder' => 'Nombre', 'required', 'autofocus']) !!}
        @include('alerts.feedback', ['field' => 'name'])
    </div>

    <div class="form-group{{ $errors->has('product_category_id') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-name">Categoría</label>
        {!! Form::select('product_category_id', $categories, null, ['class' => 'form-select form-control-alternative'.($errors->has('name') ? 'is-invalid' : ''), 'required']) !!}
        @include('alerts.feedback', ['field' => 'product_category_id'])
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-danger' : '' }}">
        <label class="form-control-label" for="input-description">Descripción</label>
        {!! Form::text('description', null, ['class' => 'form-control form-control-alternative', 'placeholder' => 'Descripción', 'required']) !!}
        @include('alerts.feedback', ['field' => 'description'])
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-group{{ $errors->has('stock') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-stock">Stock</label>
                {!! Form::number('stock', null, ['class' => 'form-control form-control-alternative', 'required']) !!}
                @include('alerts.feedback', ['field' => 'stock'])
            </div>
        </div>
        <div class="col-4">
            <div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
                <label class="form-control-label" for="input-price">Precio</label>
                {!! Form::number('price', null, ['class' => 'form-control form-control-alternative', 'required', 'step' => 100]) !!}
                @include('alerts.feedback', ['field' => 'price'])
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-success mt-4">Guardar</button>
    </div>
</div>