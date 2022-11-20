@extends('layout.user-layout')

@section('content')

@if(Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error('{{ Session::get("fail") }}', 'Fail');
        </script>
    @endpush
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        @push('scripts')
            <script>
                toastr.error('{{ $error }}', 'Failed')
            </script>
        @endpush
    @endforeach
@endif

<style>
    #map-canvas {
        height: 300px;
        width: 100%;
    }
</style>
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-content">
            <div class="container">
                <form method="POST" action="/store_service" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Create Service</div>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="row">
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Service</div>
                                        <input type="text" name="name" class="form-control" id="">
                                        <span class="danger text-danger">@error('name'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Cost</div>
                                        <input type="number" name="cost" class="form-control" id="">
                                        <span class="danger text-danger">@error('cost'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">English Level</div>
                                        <select name="english_level" id="" class="select2 form-control">
                                            <option value="Basic">Basic Level</option>
                                            <option value="Bilingual">Bilingual Level</option>
                                            <option value="Fluent">Fluent Level</option>
                                            <option value="Professional">Professional Level</option>
                                        </select>
                                        <span class="danger text-danger">@error('english_level'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Services Category</div>
                                        <select name="service_category" id="" class="select2 form-control">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="danger text-danger">@error('cost'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Type</div>
                                        <select name="type" id="" class="select2 form-control">
                                            <option value="simple">Simple</option>
                                            <option value="featured">Featured</option>>
                                        </select>
                                        <span class="danger text-danger">@error('type'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Attachment</div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="attachment[]" id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                        <span class="danger text-danger">@error('attachment'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Description</div>
                                        <textarea name="description" id="tinymce_description" cols="30" rows="8" class="form-control"></textarea>
                                        <span class="danger text-danger">@error('description'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-50">Location</div>
                                        <input type="text" name="location" id="map-search" class="form-control controls" value="{{ Auth::user()->freelancer->address }}">
                                    </div>
                                    <div class="col-md-12">
                                        <div id="map-canvas"></div>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <div class="form-group d-none">
                                            <div class="form-label font-weight-bold my-50">Latitude</div>
                                            <input type="text" name="latitude" value="" class="form-control latitude" value="{{ Auth::user()->freelancer->latitude }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6d-none">
                                        <div class="form-group d-none">
                                            <div class="form-label font-weight-bold my-50">Longitude</div>
                                            <input type="text" name="longitude" class="form-control longitude" value="{{ Auth::user()->freelancer->longitude }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer float-right my-2">
                                <button type="submit" class="btn btn-solid btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../../../js/user-location.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEmTK1XpJ2VJuylKczq2-49A6_WuUlfe4&libraries=places&callback=initialize"></script>
@endsection

@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#tinymce_description',
            height: 300
        });
    </script>
@endpush