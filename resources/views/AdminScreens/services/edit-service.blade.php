@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title font-weight-bold">Edit Service</h2>
                        <a href="/admin/services" class="btn btn-secondary">Back to List</a>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-center">
                                        Service :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="name"  value="{{ $service->name }}"  class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-center">
                                        Freelancer :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select name="freelancer" id="freelancer">
                                            <option value="{{ $service->freelancer_id }}">{{ $service->freelancer->display_name }}</option>
                                        </select>
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

@push('scripts')
    <script>
        $('#mySelect2').select2({
            ajax: {
                url: 'https://api.github.com/orgs/select2/repos',
                data: function (params) {
                var query = {
                    search: params.term,
                    type: 'public'
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
                }
            }
        });
    </script>
@endpush