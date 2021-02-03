<h6 class="heading-small text-muted mb-4">Info de la Sucursal</h6>
<div class="pl-lg-4">
    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        {!! Form::label('name', 'Alias', ['class' => 'form-control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control form-control-alternative '.($errors->has('name') ? 'is-invalid' : ''), 'placeholder' => 'Nombre', 'required', 'autofocus']) !!}
        @include('alerts.feedback', ['field' => 'name'])
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-success mt-4">Guardar</button>
    </div>
</div>
