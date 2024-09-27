@extends('admin.layouts.app')

@section('content')

<div class="content-wrapper" style="min-height: 491px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
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

            <form action="" method="post" id="discountForm" name="discountForm">
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Code">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses">Max uses</label>
                                    <input type="number" name="max_uses" id="max_uses" class="form-control" placeholder="Max uses">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses_user">Max uses user</label>
                                    <input type="number" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max uses user">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="1">On</option>
                                        <option value="0">Off</option>
                                    </select>
                                </div>
                            </div>	
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type">Coupon Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_amount">Discount amount</label>
                                    <input type="number" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount amount">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_amount">Minimum amount</label>
                                    <input type="number" name="min_amount" id="min_amount" class="form-control" placeholder="Minimum amount">	
                                    <p></p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="starts_at">When Starts Coupon</label>
                                    <input type="text" name="starts_at" id="starts_at" class="form-control" placeholder="When Starts Coupon">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expires_at">When Expires Coupon</label>
                                    <input type="text" name="expires_at" id="expires_at" class="form-control" placeholder="When Expires Coupon">	
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ route('category.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
    $(document).ready(function(){
        $('#starts_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });
        $('#expires_at').datetimepicker({
            // options here
            format:'Y-m-d H:i:s',
        });
    });

    $("#discountForm").submit(function(event) {
        event.preventDefault(); 
        var element =  $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url:'{{ route("discountcode.store")}}',
            type:'post',
            data: element.serializeArray(),
            dataType:'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true){
                    window.location.href="{{ route('discountcode.index')}}";
                    $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                        $("#slug").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                }else{
                        var errors = response['errors'];
                    if (errors['code']){
                        $("#code").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['code']);
                    }else{
                        $("#code").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }

                    if (errors['discount_amount']){
                        $("#discount_amount").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['discount_amount']);
                    }else{
                        $("#discount_amount").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                     }
                     if (errors['starts_at']){
                        $("#starts_at").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['starts_at']);
                    }else{
                        $("#starts_at").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                        
                    }
                    if (errors['expires_at']){
                        $("#expires_at").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['expires_at']);
                    }else{
                        $("#expires_at").removeClass('is-invalid')
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