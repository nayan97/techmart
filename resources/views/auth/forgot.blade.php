

@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item">Forget Password</li>
            </ol>
        </div>
    </div>
</section>
<section class=" section-10 pt-5 pb-2">
        <div class="container d-flex justify-content-center align-items-center">
            <form method="POST" action="{{ route('forgot.password') }}">
            @csrf
            <input type="email" name="email" placeholder="Enter Email" required>
            <button type="submit">Send OTP</button>
            </form>
        </div>
    </section


@endsection
