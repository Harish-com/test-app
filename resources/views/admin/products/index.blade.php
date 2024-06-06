@extends('admin.layouts.app')

@section('content')
     <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">
                            <div class="filter" style="right: 18px;">
                             <a class="btn btn-primary float-right" href="javascript:void(0)" id="addprt">  Add New </a>
                              
                            </div>
                            <div class="card-body pb-0">
                                <h5 class="card-title">Products</h5>
                                <table class="table table-bordered data-table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Products Name</th>
                                        <th>Status</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="prtForm" name="prtForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="prt_id" id="prt_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label" style="white-space: nowrap;">Products Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50">
                            <span class="text-danger" id="name_err"></span>
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label" style="white-space: nowrap;">Categories</label>
                                <div class="col-sm-12">
                                    <select id="categories_id"  class="form-select js-example-basic-multiple" name="states[]" multiple="multiple">
                                        @foreach ($categories as $id=>$val)
                                            <option value="{{ $id }}" >{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="categories_id_err"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label" style="white-space: nowrap;">Description</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="description" name="description" value="">
                                    <span class="text-danger" id="description_err"></span>
                                </div>
                             </div>
                        </div>
                   </div>

                    <div class="row">

                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="name" class="col-sm-2 control-label" style="white-space: nowrap;">Price</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" id="price" name="price" value="">
                                    <span class="text-danger" id="price_err"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="name" class="col-sm-2 control-label" style="white-space: nowrap;">Quantity </label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control numbersOnly" id="qty" name="qty" value="">
                                    <span class="text-danger" id="qty_err"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="form-group" id="checkBox" style="display:none;">
                        <label for="status" class="col-sm-2 control-label" style="white-space: nowrap; margin-right: 13px;">Status</label>
                        <input class="form-check-input" name="status" type="checkbox" id="status" >
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                        <button type="button" class="btn btn-primary" style="display:none;" id="editBtn" value="edit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    </section>       
@endsection

@push('page_scripts')
  
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    $(".numbersOnly").keypress(function (e) {
        if (e.which < 48 || 57 < e.which)
            e.preventDefault();
    });

    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#addprt').click(function () {
            $('#saveBtn').val("create");
            $('#prt_id').val('');
            $('#prtForm').trigger("reset");
            $('#modelHeading').html("Create New Products");
            $('#ajaxModel').modal('show');
        });

       

        $('#saveBtn').click(function (e) {

            var name = $('#name').val();
            var categories_id = $('#categories_id').val();
            var description = $('#description').val();
            var price = $('#price').val();
            var qty = $('#qty').val();
           
            var validate_flag = true;

            if(name == ''){
                $('#name_err').text('The Products Name is required.');
                validate_flag = false;
            }else{
                $('#name_err').text('');
            }
            if(categories_id == ''){
                $('#categories_id_err').text('The categories Name is required.');
               validate_flag = false;
            }else{
                $('#categories_id_err').text('');
            }

             if(price == ''){
                $('#price_err').text('The price is required.');
                validate_flag = false;
            }else{
                $('#price_err').text('');
            }

            if(qty == ''){
                $('#qty_err').text('The qty is required.');
                validate_flag = false;
            }else{
                $('#qty_err').text('');
            }

            if (validate_flag == false) { return false; }

            e.preventDefault();

            var formData = new FormData();

            formData.append('name', name); 
            formData.append('categories_id', categories_id); 
            formData.append('description', description); 
            formData.append('price', price); 
            formData.append('qty', qty); 

            $.ajax({
                data: formData,
                url: "{{ route('product.store') }}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                   
                  if(data.success){
                    $('#departmentForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                      toastr.success(data.success);
                    table.draw();
                  }else{
                   
                    $('#name_err').text(data.error.name);
                    $('#categories_id_err').text(data.error.categories_id);
                    $('#price_err').text(data.error.price);
                    $('#qty_err').text(data.error.qty);
                  }
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });
        $('body').on('click', '.editProducts', function () {
            var products_id = $(this).data('id');
            $.get("{{ route('product.index') }}" +'/' + products_id +'/edit', function (data) {
                $('#checkBox').show();
                $('#modelHeading').html("Edit Products");
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#ajaxModel').modal('show');
                $('#prt_id').val(data.id);
                $('#name').val(data.name);
                $('#qty').val(data.qty);
                $('#price').val(data.price);
                $('#description').val(data.description);

                var selectedValues = data.categories_id.split(',');
                $("#categories_id").val(selectedValues);
                $('.js-example-basic-multiple').select2();

                if(data.status == '1'){
                    $('#status').prop('checked',true);
                }
               
            })
        });
        $('#editBtn').click(function (e) {
           
            var products_id = $("#prt_id").val();
            var name = $('#name').val();
            var categories_id = $('#categories_id').val();
            var description = $('#description').val();
            var price = $('#price').val();
            var qty = $('#qty').val();
           
            var validate_flag = true;
            
            if(name == ''){
                $('#name_err').text('The Products Name is required.');
                validate_flag = false;
            }else{
                $('#name_err').text('');
            }
            if(categories_id == ''){
                $('#categories_id_err').text('The categories Name is required.');
               validate_flag = false;
            }else{
                $('#categories_id_err').text('');
            }

             if(price == ''){
                $('#price_err').text('The price is required.');
                validate_flag = false;
            }else{
                $('#price_err').text('');
            }

            if(qty == ''){
                $('#qty_err').text('The qty is required.');
                validate_flag = false;
            }else{
                $('#qty_err').text('');
            }

            if (validate_flag == false) { return false; }

            var editFormData = new FormData();
            editFormData.append('name', name); 
            editFormData.append('name', name); 
            editFormData.append('categories_id', categories_id); 
            editFormData.append('description', description); 
            editFormData.append('price', price); 
            editFormData.append('qty', qty); 
            editFormData.append('status', $('#status').is(':checked'));
    
            var url = '{{ route("prt.update", ":id") }}';
            url = url.replace(':id', products_id);
            e.preventDefault();
          
            $.ajax({
                data:editFormData, 
                url: url,
                type: "POST",
                dataType: 'json',
              
                contentType: false,
                processData: false,
                success: function (data) {
                 
                  if(data.success){
                    $('#prtForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                      toastr.success(data.success);
                    table.draw();
                  }else{
                  
                    $('#name_err').text(data.error.name);
                    $('#categories_id_err').text(data.error.categories_id);
                    $('#price_err').text(data.error.price);
                    $('#qty_err').text(data.error.qty);
                  }
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $('body').on('click', '.deleteProducts', function () {

            var products_id = $(this).data('id');

            var url = '{{ route("product.destroy", ":id") }}';
            url = url.replace(':id', products_id);

            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: url,
                success: function (data) {
                      toastr.error(data.success);
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

    });
</script>
@endpush
