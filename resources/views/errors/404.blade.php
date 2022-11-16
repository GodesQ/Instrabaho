@extends('layout.error-layout')

@section('title', '404 - Not Found')

@section('content')
    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh;">
        <img src="{{ URL::asset('images/errors/404-error.png')}}" alt="" class="img-responsive" style="max-width: 400px !important;">
        <h1 class="text-center">Page not found.</h1>
        <a href="/" class="btn btn-primary">Back to Home</a>
    </div>
@endsection