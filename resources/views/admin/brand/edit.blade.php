@extends('admin.layouts.app')

@section('content')

<div class="content-wrapper" style="min-height: 491px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>edit Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('brand.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">

            <form action="" method="post" id="updateBrandForm" name="updateBrandForm">
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{$brand->name}}" type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input value="{{$brand->slug}}" type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option {{ ($brand->status == 1) ? 'selected' : ''}} value="1">On</option>
                                        <option {{ ($brand->status == 0) ? 'selected' : ''}} value="0">Off</option>
                                    </select>
                                </div>
                            </div>										
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('brand.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>


@endsection
@section('customJs')

<script>
    $("#updateBrandForm").submit(function(event) {
    event.preventDefault(); 
    var element =  $(this);
    $("button[type=submit]").prop('disabled', true);
    $.ajax({
        url:'{{ route("brand.update", $brand -> id)}}',
        type:'put',
        data: element.serializeArray(),
        dataType:'json',
        success: function(response){
            $("button[type=submit]").prop('disabled', false);
            if (response["status"] == true){
                window.location.href="{{ route('brand.index')}}";
                $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                    $("#slug").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

            }else{
                if (response['notFound'] == true){

                    window.location.href="{{ route('brand.index')}}";
                }
                    var errors = response['errors'];
                if (errors['name']){
                    $("#name").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback').html(errors['name']);
                }else{
                    $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");
                }

                if (errors['slug']){
                    $("#slug").addClass('is-invalid')
                    .siblings('p')
                    .addClass('invalid-feedback').html(errors['slug']);
                }else{
                    $("#slug").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                 }
     
            }


        }, error: function(jqXHR, exception){

        }

    });
});

</script>
    
@endsection