@extends('layout.error-layout')

@section('title', '404 - Not Found')

@section('content')
    <div class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh;">
        <img src="{{ URL::asset('images/errors/403-error.png')}}" alt="" class="img-responsive" style="max-width: 400px !important;">
        <h1 class="text-center">The page you're trying to access has restricted.</h1>
        <a href="/" class="btn btn-primary">Back to Home</a>
    </div>
@endsection