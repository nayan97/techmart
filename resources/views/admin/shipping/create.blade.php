@extends('admin.layouts.app')

@section('content')

<div class="content-wrapper" style="min-height: 491px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('subcategory.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">

            <form action="" method="post" id="shippingForm" name="shippingForm">
                <div class="card">
                    <div class="card-body">	
                        @include('admin.validate')							
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <select name="country" id="country" class="form-control">
                                        <option value="">Select a Country</option>
                                        @if ($countries -> isNotEmpty()) 
                                            @foreach ($countries as $country) 
                                                <option value="{{ $country->id}}">{{ $country->name }}</option>
                                        @endforeach
                                            <option value="rest_of_world">Rest Of the world</option>
                                        @endif
                                        
                                    </select>
                                    <P></P>
                                </div>
                            </div>	
                            <div class="col-md-6"> 
                                <label for="charge">Shipping Charge</label>
                                <input type="text" name="amount" id="amount" class="form-control"> 
                                <p></p>      
                            </div>								
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
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
    $("#shippingForm").submit(function(event) {
        event.preventDefault(); 
        var element =  $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url:'{{ route("shipping.store")}}',
            type:'post',
            data: element.serializeArray(),
            dataType:'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true){
                    window.location.href="{{ route('shipping.create')}}";
  
                }else{
                        var errors = response['errors'];
                    if (errors['country']){
                        $("#country").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['country']);
                    }else{
                        $("#country").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                    }

                    if (errors['amount']){
                        $("#amount").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['amount']);
                    }else{
                        $("#amount").removeClass('is-invalid')
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