
{!! Form::open(['route' => ['user.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>

    <a href="{{ route('user.show', $id) }}" class='btn btn-default btn-sm'>
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('user.edit', $id) }}" class='btn btn-default btn-sm'>
        <i class="fa fa-edit"></i>
    </a>


{{--    <input onchange="cStatus({{$id}});" data-id="{{$id}}" class="toggle-class" type="checkbox" data-onstyle="success"--}}
{{--           data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $status ? 'checked' : '' }}>--}}

    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}


