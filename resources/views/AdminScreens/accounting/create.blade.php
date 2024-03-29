@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container my-2">
                    <form action="{{ route('admin.accounting.store') }}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Create Accouting</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Firstname</div>
                                            <input type="text" class="form-control" name="firstname" id="firstname">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Middlename</div>
                                            <input type="text" class="form-control" name="middlename" id="middlename">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Lastname</div>
                                            <input type="text" class="form-control" name="lastname" id="lastname">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Email</div>
                                            <input type="email" class="form-control" name="email" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Username</div>
                                            <input type="text" class="form-control" name="username" id="username">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Password</div>
                                            <input type="password" class="form-control" name="password" id="password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="reset" class="btn btn-warning">Cancel</button>
                                <button type="submit"class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
