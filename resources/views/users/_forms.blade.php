<h6 class="heading-small text-muted mb-4">Info del Usuario</h6>
<div class="pl-lg-4">
    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
        {!! Form::label('name', 'Nombre', ['class' => 'form-control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control form-control-alternative '.($errors->has('name') ? 'is-invalid' : ''), 'placeholder' => 'Nombre', 'required', 'autofocus']) !!}
        @include('alerts.feedback', ['field' => 'name'])
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
        {!! Form::label('email', 'Correo', ['class' => 'form-control-label']) !!}
        {!! Form::email('email', null, ['class' => 'form-control form-control-alternative '.($errors->has('email') ? 'is-invalid' : ''), 'placeholder'=>'Email', 'required']) !!}
        @include('alerts.feedback', ['field' => 'email'])
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
        {!! Form::label('password', 'Contraseña', ['class' => 'form-control-label']) !!}
        {!! Form::password('password', ['class' => 'form-control form-control-alternative '.($errors->has('password') ? 'is-invalid' : ''), 'placeholder' => 'Contraseña', isset($user) ? '':'required']) !!}
        @include('alerts.feedback', ['field' => 'password'])
    </div>
    <div class="form-group">
        {!! Form::label('password_confirmation', 'Repetir Contraseña', ['class' => 'form-control-label']) !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control form-control-alternative', 'placeholder' => 'Confirmar Contraseña', isset($user) ? '':'required']) !!}
    </div>

    <div class="form-group{{ $errors->has('branches[]') ? ' has-danger' : '' }} col-md-3">
        {!! Form::label('branches[]', 'Sucursales', ['class' => 'form-control-label']) !!}
        {!! Form::select('branches[]', $branches, null, ['class' => 'form-select', 'required', 'multiple']) !!}
        @include('alerts.feedback', ['field' => 'branches[]'])
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-success mt-4">Guardar</button>
    </div>
</div>
