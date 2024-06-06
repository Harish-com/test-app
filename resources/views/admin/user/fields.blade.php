<!-- Title Field -->
<div class="form-group col-sm-12 mb-3">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('name') }}</span>
</div>
<div class="form-group col-sm-6 mb-3">
    {!! Form::label('username', 'UserName:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('username') }}</span>
</div>
<div class="form-group col-sm-6 mb-3">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('email') }}</span>
</div>
@if(isset($user))

<div class="form-group col-sm-6 mb-3">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', ['active'=>"Active",'in-active'=>"InActive"],null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('status') }}</span>
</div>
<div class="form-group col-sm-6 mb-3">
    {!! Form::label('avatar', 'Avatar:') !!}<br>
    {!! Form::file('avatar', null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('avatar') }}</span>
</div>
<div class="form-group col-sm-6 mb-3">
    {!! Form::label('address', 'Address:') !!}<br>
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('address') }}</span>
</div>
<div class="form-group col-sm-6 mb-3">
    {!! Form::label('gender', 'Gender:') !!}<br>
    {!! Form::select('gender', ['male'=>"Male",'female'=>"Female"], null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('gender') }}</span>
</div>
<div class="form-group col-sm-6 mb-3">
    {!! Form::label('date_of_birth', 'DOB:') !!}<br>
    {!! Form::date('date_of_birth', null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('date_of_birth') }}</span>
</div>
@endif

<div class="form-group col-sm-6 mb-3">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::text('password', null, ['class' => 'form-control']) !!}
    <span class="error text-danger">{{ $errors->first('password') }}</span>
</div>



