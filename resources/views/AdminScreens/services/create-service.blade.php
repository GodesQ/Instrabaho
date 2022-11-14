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

<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between aJlign-items-center">
                    <h2 class="card-title font-weight-bold">Create Service</h2>
                    <a href="/admin/services" class="btn btn-secondary">Back to List</a>
                </div>
                <hr>
                <div class="card-body">
                    <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_type" value="{{ base64_encode('admin') }}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="font-weight-bold text-right">
                                    Service :
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="name"  value=""  class="form-control">
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
                                            <option value=""></option>
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
                                    Service Category :
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="service_category" id="service_category" class="select2">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="font-weight-bold text-right">
                                    Attachments :
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="file" name="attachment[]" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="font-weight-bold text-right">
                                    Cost :
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="number" name="cost"  value=""  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="font-weight-bold text-right">
                                            English Level :
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select name="english_level" id="" class="select2 form-control">
                                                <option value="Basic" >Basic Level</option>
                                                <option value="Bilingual" >Bilingual Level</option>
                                                <option value="Fluent">Fluent Level</option>
                                                <option value="Professional">Professional Level</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="font-weight-bold text-right">
                                            Service Type :
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <select name="type" id="" class="select2 form-control">
                                                <option value="simple">Simple </option>
                                                <option value="featured">Featured </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="font-weight-bold text-right">
                                    Service Description :
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="font-weight-bold text-right">
                                    Location <br>
                                    <span style="font-size: 10px;" class="font-weight-normal">(You can drag the marker to get the specific location.)</span>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="map-search" name="location" value=""> <br>
                                    <div id="map-canvas"></div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label font-weight-bold my-50">Latitude</div>
                                                <input type="text" name="latitude" value="" class="form-control latitude">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label font-weight-bold my-50">Longitude</div>
                                                <input type="text" name="longitude" value="" class="form-control longitude">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-footer float-right">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../../../js/user-location.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
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
