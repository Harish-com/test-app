@push('third_party_stylesheets')
    @include('admin.layouts.datatables_css')
@endpush

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('third_party_scripts')
    @include('admin.layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
