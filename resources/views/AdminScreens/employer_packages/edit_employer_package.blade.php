@extends('layout.admin-layout')

@section('content')
    @if(Session::get('success'))
        @push('scripts')
            <script>
                toastr.success("{{ Session::get('success') }}", 'Success');
            </script>
        @endpush
    @endif
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Update Employer Package</div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.employer_packages.update') }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $package->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label font-weight-bold">Name</label>
                                        <input type="text" name="name" value="{{ $package->name }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label font-weight-bold">Price</label>
                                        <input type="number" name="price" value="{{ $package->price }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label font-weight-bold">Total Allowed Projects</label>
                                        <input type="text" name="total_projects" value="{{ $package->total_projects }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label font-weight-bold">Total Create Featured Projects</label>
                                        <input type="text" name="total_feature_projects" value="{{ $package->total_feature_projects }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label font-weight-bold">Expiry Days</label>
                                        <input type="number" name="expiry_days" value="{{ $package->expiry_days }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" value="1" name="isProfileFeatured" id="customSwitch1" {{ $package->isProfileFeatured ? 'checked' : null }}>
                                        <label class="custom-control-label" for="customSwitch1">Feature Project</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer float-right">
                                <a href="/admin/employer_packages" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection