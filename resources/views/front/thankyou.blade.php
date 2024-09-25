@extends('front.layouts.app')

@section('content')
<section style="min-height: 400px;">
    <div class="container">
        <div class="col-md-12 text-center py-5">
            @include('front.validate')
            <h1>Thank You!</h1>
            <p>Your Order in prgress</p>



        </div>
    </div>
</section>


@endsection