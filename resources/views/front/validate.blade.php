@if( $errors -> any())
    <p class="alert alert-danger">{{$errors -> first()}} <button class="close" data-dismiss="alert">&times;</button></p>

@endif


@if(Session::has('success-main'))
    <p class="alert alert-success">{{Session::get('success-main')}} <button class="close" data-dismiss="alert">&times;</button></p>

@endif


@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

 @endif


 @if(Session::has('error'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{Session::get('error')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
 @endif