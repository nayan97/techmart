@if( $errors -> any())
    <p class="alert alert-danger">{{$errors -> first()}} <button class="close" data-dismiss="alert">&times;</button></p>

@endif


@if(Session::has('success-main'))
    <p class="alert alert-success">{{Session::get('success-main')}} <button class="close" data-dismiss="alert">&times;</button></p>

@endif


@if(Session::has('success'))
    <p class="alert alert-success">{{Session::get('success')}} <button class="close" data-dismiss="alert">&times;</button></p>

 @endif


 @if(Session::has('error'))
    <p class="alert alert-danger">{{Session::get('error')}} <button class="close" data-dismiss="alert">&times;</button></p>

 @endif