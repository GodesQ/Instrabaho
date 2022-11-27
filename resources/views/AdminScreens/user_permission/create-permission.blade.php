@extends('layout.admin-layout')

@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Error')
            </script>
        @endpush
    @endforeach
@endif

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Create Permission</div>
                        <form action="{{ route('admin.user_permissions.store') }}" class="form" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="permission">Permission</label>
                                        <input type="text" class="form-control" name="permission" id="permission">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="roles">Roles</label>
                                        <br>
                                        <div class="row">
                                            @foreach ($user_types as $user_type)
                                                <div class="col-md-6">
                                                    <input type="checkbox" {{$user_type->slug == 'super_admin' ? 'checked' : null }} name="roles[]" id="roles" value="{{ $user_type->slug }}"> {{$user_type->role}} <br> <br>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer float-right">
                                <a class="btn btn-secondary" href="/admin/user_permissions">Cancel</a>
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
