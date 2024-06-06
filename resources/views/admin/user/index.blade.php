@extends('admin.layouts.app')

@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
{{--                    <h1>question</h1>--}}
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('user.create') }}">
                        Add New
                    </a>
                </div>
            </div>

        </div>
    </section>

    <div class="content px-3">

        @include('admin.flash-message')

{{--        <div class="clearfix"></div>--}}

        <div class="card">
            <div class="card-body ">
                <h5 class="card-title">User Table</h5>
                @include('admin.user.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
{{--                        @include('adminlte-templates::common.paginate', ['records' => $blogs])--}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('page_scripts')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        function cStatus(id){
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('/changeStatus') }}',
                data: {'id': id},
                success: function(data){
                    var table = $('#dataTableBuilder').DataTable();
                    table.ajax.reload();
                }
            });
        }

    </script>
@endpush
