@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible ">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif
@if ($message = Session::get('danger'))
    <div class="alert alert-danger alert-dismissible">
        <div class="alert-body">
            <button class="close" data-dismiss="alert">
                <span>×</span>
            </button>
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible ">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        <strong>{{ $message }}</strong>
    </div>
</div>

@endif

