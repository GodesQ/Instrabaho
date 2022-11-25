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

@if (Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success')
        </script>
    @endpush
@endif

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit Permission</div>
                        <hr>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.user_permissions.update') }}" class="form" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $permission->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="permission">Permission</label>
                                        <input type="text" class="form-control" name="permission" id="permission"value="{{ $permission->permission }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="roles">Roles</label>
                                        <br>
                                        <div class="row">
                                            @php
                                                $selected_user_types = explode("|", $permission->roles);
                                            @endphp
                                            @foreach ($user_types as $user_type)
                                                <div class="col-md-12">
                                                    <input type="checkbox" {{in_array($user_type->slug, $selected_user_types) ? 'checked' : null}} name="roles[]" id="roles" value="{{ $user_type->slug }}"> {{$user_type->role}} <br> <br>
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
