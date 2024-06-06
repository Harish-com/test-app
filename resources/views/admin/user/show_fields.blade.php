<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $user->id }}</p>
</div>
<div class="col-sm-12">
    {!! Form::label('generated_id', 'Generated Id:') !!}
    <p>{{ $user->generated_id ?? " " }}</p>
</div>

<!-- User Id Field -->


<!-- Driver Id Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('username', 'UserName:') !!}
    <p>{{ $user->username ?? " " }}</p>
</div>

<!-- Weekly Off Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $user->status }}</p>
</div>
<div class="col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $user->userDetail->address ?? " " }}</p>
</div>

<div class="col-sm-12">
    {!! Form::label('gender', 'Gender:') !!}
    <p>{{ $user->userDetail->gender ?? " " }}</p>
</div>
<div class="col-sm-12">
    {!! Form::label('gender', 'Gender:') !!}
    <p>{{ $user->userDetail->gender ?? " " }}</p>
</div>

<div class="col-sm-12">
    {!! Form::label('avatar', 'Avatar:') !!}
    <p><img alt="image" src="{{asset('storage/avatar/'.$user->avatar)}}" style="width: 106px;height: 80px;"></p>
</div>




