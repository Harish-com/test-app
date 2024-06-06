@extends('admin.layouts.app')

@section('content')



     <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">
                            <div class="filter" style="right: 18px;">
                             <a class="btn btn-primary float-right" href="javascript:void(0)" id="addCategories">  Add New </a>
                              
                            </div>
                            <div class="card-body pb-0">
                                <h5 class="card-title">Categories</h5>
                                <table class="table table-bordered data-table">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Categories Name</th>
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
                <form id="categoriesForm" name="categoriesForm" class="form-horizontal">
                    <input type="hidden" name="categories_id" id="categories_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label" style="white-space: nowrap;">Categories Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50">
                            <span class="text-danger" id="name_err"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label" style="white-space: nowrap;">Categories description</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" value="" >
                            <span class="text-danger" id="description_err"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="photo" class="col-sm-2 control-label">Image</label>
                        <input class="form-file-input" name="photo" type="file" id="photo" accept=".jpeg,.jpg,.png,.gif"><br>
                        <img src="" id="photo_pre" style="width: 80px; height: 70px; display:none; margin-left: 324px;" >
                        <span class="col-sm-2 control-label text-danger small" id="photo_err"></span>
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
  
  
<script type="text/javascript">
   
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('categories.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#addCategories').click(function () {
            $('#saveBtn').val("create");
            $('#categories_id').val('');
            $('#categoriesForm').trigger("reset");
            $('#modelHeading').html("Create New categories");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editCategories', function () {
            var categories_id = $(this).data('id');
            $.get("{{ route('categories.index') }}" +'/' + categories_id +'/edit', function (data) {
                $('#checkBox').show();
                $('#modelHeading').html("Edit categories");
                $('#saveBtn').hide();
                $('#editBtn').show();
                $('#ajaxModel').modal('show');
                $('#categories_id').val(data.id);
                $('#name').val(data.name);
                $('#description').val(data.description);
                //$('#photo').val(data.photo);
                $('#photo_pre').attr('src',data.photo);
                $('#photo_pre').show();
                if(data.status == '1'){
                    $('#status').prop('checked',true);
                }
               
            })
        });

        $('#saveBtn').click(function (e) {

            var name = $('#name').val();
            var description = $('#description').val();
            var img = $('#photo').val();
         
            if(name == ''){
                $('#name_err').text('The Name field is required.');
                return false;
            }else{
                $('#name_err').text('');
            }

            if(img == ''){
                $('#photo_err').text('The image field is required.');
                return false;
            }else{
                $('#photo_err').text('');
            }
           
            e.preventDefault();

            var formData = new FormData();

            formData.append('name', name); 
            formData.append('description', description); 
            formData.append('photo', $('input[type=file]')[0].files[0]);  // Attach file

            $.ajax({
                data: formData,
                url: "{{ route('categories.store') }}",
                type: "POST",
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                   
                  if(data.success){
                   
                    $('#categoriesForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    // $('.alert-success').show();
                    //  $('#s_msg').text(data.success);
                    toastr.success(data.success);
                    table.draw();
                  }else{
                   
                    $('#name_err').text(data.error.name);
                    $('#photo_err').text(data.error.photo);
                  }
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $('#editBtn').click(function (e) {
            var categories_id = $("#categories_id").val();
            var name = $('#name').val();
            var description = $('#description').val();

            if(name == ''){
                $('#name_err').text('The categories Name field is required.');
                return false;
            }else{
                $('#name_err').text('');
            }
            
                       var url = '{{ route("cate.updates", ":id") }}';
            url = url.replace(':id', categories_id);

           
            e.preventDefault();
          
            var formData = new FormData();

            formData.append('name', name); 
            formData.append('description', description); 
            formData.append('status', description); 
            formData.append('status', $('#status').is(':checked'));

            formData.append('photo', $('input[type=file]')[0].files[0]);  // Attach file

           $.ajax({
            data: formData,
            url: url,
            type: "POST",
            dataType: 'json',
            contentType: false,
            processData: false,
                success: function (data) {
                    if(data.success){
                        toastr.success(data.success);
                        $('#categoriesForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    } else {
                        $('#name_err').text(data.error.name);
                        $('#photo_err').text(data.error.photo);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save Changes');
                }
            });
        });

        $('body').on('click', '.deletecategories', function () {

            var categories_id = $(this).data('id');

            var url = '{{ route("categories.destroy", ":id") }}';
            url = url.replace(':id', categories_id);

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
