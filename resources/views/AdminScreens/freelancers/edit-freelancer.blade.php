@extends('layout.admin-layout')

@section('content')
    <style>
        .form-control {
            background: #transparent !important;
            border:  !important;
        }
    </style>
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h2 class="font-weight-bold">User</h2>
                        <hr>
                        <form action="" method="post">
                            @method('PUT')
                            @csrf
                            <div class="container">
                                <div class="row my-1">
                                    <div class="col-lg-2 col-md-12">
                                        <div class="font-weight-bold text-right">
                                            Username:
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-12">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row my-1">
                                    <div class="col-lg-2 col-md-12">
                                        <div class="font-weight-bold text-right">
                                            Email:
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-12">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection