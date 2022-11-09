@extends('layout.user-layout')

@section('content')
<div class="page-wrapper">
    @if(Session::get('success'))
        @push('scripts')
            <script>
                toastr.success("{{ Session::get('success') }}", 'Sucess');
            </script>
        @endpush
    @endif
    <style>
        #map-canvas {
            height: 300px;
            width: 100%;
        }
    </style>
    <div class="page-header">
        <div class="page-content">
            <div class="container-fluid">
                <ul class="nav nav-tabs nav-underline no-hover-bg" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="base-tab31" data-toggle="tab" aria-controls="tab31" href="#tab31" role="tab" aria-selected="true">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab32" data-toggle="tab" aria-controls="tab32" href="#tab32" role="tab" aria-selected="false">Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab33" data-toggle="tab" aria-controls="tab33" href="#tab33" role="tab" aria-selected="false">Approved Offers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab34" data-toggle="tab" aria-controls="tab34" href="#tab34" role="tab" aria-selected="false">Calendar</a>
                    </li>
                </ul>
                <div class="tab-content px-1 pt-1">
                    <div class="tab-pane active" id="tab31" role="tabpanel" aria-labelledby="base-tab31">
                        <form method="POST" action="/update_service" enctype="multipart/form-adta">
                            @csrf
                            <input type="hidden" name="id" value="{{ $service->id }}">
                            <input type="hidden" name="freelancer" value="{{ $service->freelancer_id }}">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="card-title">Update Service</div>
                                    <a href="/services" class="btn btn-dark">Back to Services</a>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <div class="row my-1">
                                        <div class="col-md-12">
                                            <h4>Attachments</h4>
                                            <div class="row">
                                                <input type="hidden" name="$service_images">
                                                @foreach($service_images as $key => $image)
                                                    <div class="col-lg-1 col-md-2 col-sm-3">
                                                        <img src="../../../images/services/{{ $image }}" alt="attachment" class="my-75" width="100"> <br>
                                                        <a href="#" id="{{ $key }}" class="remove-attachment btn btn-sm btn-danger">Remove</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label font-weight-bold my-1">Service</div>
                                                <input type="text" name="name" class="form-control" id="" value="{{ $service->name }}">
                                                <span class="danger text-danger">@error('name'){{ $message }}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label font-weight-bold my-1">Cost</div>
                                                <input type="number" name="cost" class="form-control" id="" value="{{ $service->cost }}">
                                                <span class="danger text-danger">@error('cost'){{ $message }}@enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label font-weight-bold my-1">English Level</div>
                                                <select name="english_level" id="" class="select2 form-control">
                                                    <option value="Basic" {{ $service->english_level == 'Basic' ? 'selected' : null }}>Basic Level</option>
                                                    <option value="Bilingual" {{ $service->english_level == 'Bilingual' ? 'selected' : null }}>Bilingual Level</option>
                                                    <option value="Fluent" {{ $service->english_level == 'Fluent' ? 'selected' : null }}>Fluent Level</option>
                                                    <option value="Professional" {{ $service->english_level == 'Professional' ? 'selected' : null }}>Professional Level</option>
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
                                                        <option {{ $service->service_category == $category->id ? 'selected' : null }} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                    <option {{ $service->type == 'simple' ? 'selected' : null }} value="simple">Simple</option>
                                                    <option {{ $service->type == 'featured' ? 'selected' : null }} value="featured">Featured</option>>
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
                                                <textarea name="description" id="tinymce_description" cols="30" rows="8" class="form-control">{{ $service->description }}</textarea>
                                                <span class="danger text-danger">@error('description'){{ $message }}@enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="map-search" name="location" value="{{ $service->location }}"> <br>
                                                <div id="map-canvas"></div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group d-none">
                                                            <div class="form-label font-weight-bold my-50">Latitude</div>
                                                            <input type="text" name="latitude" value="{{ $service->latitude }}" class="form-control latitude">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group d-none">
                                                            <div class="form-label font-weight-bold my-50">Longitude</div>
                                                            <input type="text" name="longitude" value="{{ $service->longitude }}" class="form-control longitude">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-footer float-right">
                                        <button type="submit" class="btn btn-solid btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab32" role="tabpanel" aria-labelledby="base-tab32">
                        <div class="container">
                            @include('UserAuthScreens.services_proposals.freelancer.pending', [$pending_offers])
                        </div>
                    </div>
                    <div class="tab-pane" id="tab33" role="tabpanel" aria-labelledby="base-tab33">
                        <p>Biscuit ice cream halvah candy canes bear claw ice cream cake chocolate bar donut. Toffee cotton candy liquorice. Oat cake lemon drops gingerbread dessert caramels. Sweet dessert jujubes powder sweet sesame snaps.</p>
                    </div>
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

        tinymce.init({
            selector: 'textarea#tinymce_description',
            height: 300
        });

        $(document).ready(function () {
            $(document).on("click", ".remove-attachment", function (e) {
                let key_id = $(this).attr("id");
                let service_id = '{{ $service->id }}';
                let csrf = "{{ csrf_token() }}";
                Swal.fire({
                    title: "Remove Image",
                    text: "Are you sure you want to remove this?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/remove_image/${service_id}/${key_id}`,
                            success: function (response) {
                                if(response.status == 201) {
                                    Swal.fire(
                                        "Removed!",
                                        "Record has been removed.",
                                        "success"
                                    ).then((result) => {

                                    });
                                } else {
                                    Swal.fire(
                                        "Fail!",
                                        `${response.message}`,
                                        "error"
                                    ).then((result) => {

                                    });
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush
