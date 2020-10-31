<h6 class="heading-small text-muted mb-4">Pagamento a realizar</h6>

<div class="row">

    <div class="col-lg-3">

        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-address">Direccion</label>
            {!! Form::text('address', null, ['class' => 'form-control form-control-alternative '.($errors->has('address') ? 'is-invalid' : ''), 'placeholder' => 'Direccion', 'autofocus']) !!}
            @include('alerts.feedback', ['field' => 'address'])
        </div>
    </div>
    <div class="col-lg-3">

        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-phone">Telefono *</label>
            {!! Form::text('phone', null, ['class' => 'form-control form-control-alternative '.($errors->has('phone') ? 'is-invalid' : ''), 'placeholder' => 'Telefono', 'required', 'autofocus']) !!}
            @include('alerts.feedback', ['field' => 'phone'])
        </div>
    </div>
    <div class="pl-lg-3">

        <div class="form-group{{ $errors->has('document_id') ? ' has-danger' : '' }}">

            <label class="form-control-label" for="input-document_id">Cedula</label>
            {!! Form::text('document_id', null, ['class' => 'form-control form-control-alternative '.($errors->has('document_id') ? 'is-invalid' : ''), 'placeholder' => 'Cedula', 'autofocus']) !!}
            @include('alerts.feedback', ['field' => 'document_id'])
        </div>
    </div>
    <div class="pl-lg-3">

        <label class="form-control-label" for="input-genre">Genero *</label>

        <div class="form-group{{ $errors->has('genre') ? ' has-danger' : '' }}">

            <label class="form-control-label" for="input-genre">M</label>
            {!! Form::radio('genre', 1, ['class' => ($errors->has('genre') ? 'is-invalid' : ''), 'required', 'autofocus']) !!}
            @include('alerts.feedback', ['field' => 'genre'])

            <label class="form-control-label" for="input-genre">F</label>

            {!! Form::radio('genre', 2, ['class' => ($errors->has('genre') ? 'is-invalid' : ''), 'required', 'autofocus'] ) !!}
            @include('alerts.feedback', ['field' => 'genre'])
        </div>
    </div>


</div>

<div class="row">
    <div class="col-4">
        <div class="form-group{{ $errors->has('salary') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-salary">Salario *</label>
            {!! Form::number('salary', null, ['class' => 'form-control form-control-alternative', 'required']) !!}
            @include('alerts.feedback', ['field' => 'salary'])
        </div>
    </div>

</div>

<div class="text-center">
    <button type="submit" class="btn btn-success mt-4">Guardar</button>
</div>
</div>