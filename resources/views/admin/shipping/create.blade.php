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
            <hr>
            <div class="card-body table-responsive p-0">								
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th>Name</th>
                            <th>amount</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ( $shippingCharges->isNotEmpty())
                            @foreach ( $shippingCharges as $item )
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    {{($item->country_id == 'rest_of_world') ? 'Rest of the World' : $item->name}}
                                </td>
                                <td>{{$item->amount}}</td>
                 
                                <td>
                                    <a href="{{ route('shipping.edit', $item->id)}}">
                                        <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0);" onclick="deleteRecord({{$item->id}})" class="text-danger w-4 h-4 mr-1">
                                        <svg wire:loading.remove.delay="" wire:target="" class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path ath="" fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                          </svg>
                                    </a>
                                </td>
                            </tr>
                                
                            @endforeach
                            
                        @else

                            <tr>
                                <p>No Data Founds</p>
                            </tr>
                            
                        @endif
                     
                      
       
                    </tbody>
                </table>										
            </div>
            <div class="card-footer clearfix">
                <ul class="pagination pagination m-0 float-right">
                    {{-- {{ $countries-> links()}} --}}
                  {{-- <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li> --}}
                </ul>
            </div>
        
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

        })
    });

function deleteRecord(id){
        var url = '{{route("shipping.delete","ID")}}';
        var newUrl = url.replace("ID",id);

        if (confirm('Are you sure you want to delete')){
            $.ajax({
            url: newUrl,
            type:'delete',
            data:{},
            dataType:'json',
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                        success: function(response){
                if (response["status"]){
                    window.location.href="{{ route('shipping.create')}}";
   
                }

            }

        });
        }
    


    }
   

</script>
@endsection