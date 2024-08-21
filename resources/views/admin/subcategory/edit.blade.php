@extends('admin.layouts.app')

@section('content')

<div class="content-wrapper" style="min-height: 491px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('category.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">

            <form action="" method="put" id="subCatForm" name="subCatForm">
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                        
                                        @if (!empty($categories)){
                                        @foreach ($categories as $item)
                                            
                                         <option {{ ($subcategory ->category_id == $item->id ) ? 'selected' : '' }} value="{{ $item->id}}">{{$item->name}}</option>
                                        @endforeach
                                        
                                        }
                                        @endif
                                      
                                    </select>
                                    <p></p>
                                 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{ $subcategory->name}}" type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input value="{{ $subcategory->slug}}" type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p></p>	
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option {{ ($subcategory ->status == 1 ) ? 'selected' : '' }} value="1">On</option>
                                        <option {{ ($subcategory ->status == 0 ) ? 'selected' : '' }} value="0">Off</option>
                                    </select>
                                </div>
                            </div>	
                    									
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('subcategory.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
    $("#subCatForm").submit(function(event) {
        event.preventDefault(); 
        var element =  $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url:'{{ route("subcategory.update", $subcategory ->id)}}',
            type:'put',
            data: element.serializeArray(),
            dataType:'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true){
                    window.location.href="{{ route('subcategory.index')}}";
                    $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $("#slug").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                }else{
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