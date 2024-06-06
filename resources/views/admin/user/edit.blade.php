
@extends('admin.layouts.app')

@section('content')


    <div class="content px-3">
        <div class="card">
            {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'patch','files' => true]) !!}

            <div class="card-body">
                <h5 class="card-title">Edit User</h5>
                <div class="row">
                    @include('admin.user.fields')
                </div>
            </div>
            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('user.index') }}" class="btn btn-default">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
