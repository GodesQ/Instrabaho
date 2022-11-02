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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Edit Addon</h2>
                        <a href="/admin/addons" class="btn btn-secondary">Back to List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('addon.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $addon->id }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Name :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="title" value="{{ $addon->title }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Freelancer :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group d-flex justify-content-between align-items-center" style="gap: 10px;">
                                        <div style="width:75% !important;">
                                            <select name="freelancer" id="freelancer_select" style="width: 100% !important;">
                                                <option value="{{ $addon->user_role_id }}">{{ $addon->freelancer->display_name }}</option>
                                            </select>
                                        </div>
                                        <div style="width: 25% !important;">
                                            <select name="search_freelancer_type" id="search_freelancer_type" class="select2" style="width: 100% !important;">
                                                <option value="display_name">Display Name Search</option>
                                                <option value="full_name">Full Name Search</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Cost :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="price" value="{{ $addon->price }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-right">
                                        Description :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <textarea class="form-control" name="description" cols="8" rows="8">{{ $addon->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
         $('#freelancer_select').select2({
            ajax: {
                delay: 250,
                url: '{{ route("admin.freelancers.search") }}',
                data: function (params) {
                let query = {
                    search: params.term,
                    type: $('#search_freelancer_type').val()
                }
                return query;
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });
    </script>
@endpush
