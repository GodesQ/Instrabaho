@extends('layout.admin-layout')

@section('content')

@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success');
        </script>
    @endpush
@endif

    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container my-2">
                    <form action="{{ route('admin.accounting.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $accounting->id }}">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Edit Accouting</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Firstname</div>
                                            <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $accounting->firstname }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Middlename</div>
                                            <input type="text" class="form-control" name="middlename" id="middlename" value="{{ $accounting->middlename }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Lastname</div>
                                            <input type="text" class="form-control" name="lastname" id="lastname" value="{{ $accounting->lastname }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Email</div>
                                            <input type="email" disabled class="form-control" name="email" id="email" value="{{ $accounting->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-50">Username</div>
                                            <input type="text" class="form-control" name="username" id="username" value="{{ $accounting->username }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="/admin/accountings" class="btn btn-warning">Cancel</a>
                                <button type="submit"class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
