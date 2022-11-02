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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title font-weight-bold">Edit Service</h2>
                        <a href="/admin/services" class="btn btn-secondary">Back to List</a>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <input type="hidden" name="$service_images">
                                    @foreach($service_images as $key => $image)
                                        <div class="col-lg-1 col-md-3 col-sm-3" style="margin: 0 10px;">
                                            <img src="../../../images/services/{{ $image }}" alt="attachment" class="my-50" width="100" height="100" style="object-fit: contain;"> <br>
                                            <a href="#" id="{{ $key }}" class="remove-attachment btn btn-sm btn-danger">Remove</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <hr>
                        <form action="{{ route('service.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $service->id }}">
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
                                    <div class="form-group d-flex justify-content-between align-items-center" style="gap: 10px;">
                                        <div style="width:75% !important;">
                                            <select name="freelancer" id="freelancer_select" style="width: 100% !important;">
                                                <option value="{{ $service->freelancer_id }}">{{ $service->freelancer->display_name }}</option>
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
                                    <div class="font-weight-bold text-center">
                                        Service Category :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <select name="service_category" id="service_category" class="select2">
                                            @foreach($categories as $category)
                                                <option {{ $category->id == $service->service_category ? 'selected' : null }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-center">
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
                                    <div class="font-weight-bold text-center">
                                        Cost :
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" name="cost"  value="{{ $service->cost }}"  class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="font-weight-bold text-center">
                                                English Level :
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select name="english_level" id="" class="select2 form-control">
                                                    <option value="Basic" {{ $service->english_level == 'Basic' ? 'selected' : null }}>Basic Level</option>
                                                    <option value="Bilingual" {{ $service->english_level == 'Bilingual' ? 'selected' : null }}>Bilingual Level</option>
                                                    <option value="Fluent" {{ $service->english_level == 'Fluent' ? 'selected' : null }}>Fluent Level</option>
                                                    <option value="Professional" {{ $service->english_level == 'Professional' ? 'selected' : null }}>Professional Level</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="font-weight-bold text-center">
                                                Service Type :
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <select name="type" id="" class="select2 form-control">
                                                    <option value="simple" {{ $service->type == 'simple' ? 'selected' : null }}>Simple </option>
                                                    <option value="featured" {{ $service->type == 'featured' ? 'selected' : null }}>Featured </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-center">
                                        Service Description :
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $service->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="font-weight-bold text-center">
                                        Location <br>
                                        <span style="font-size: 10px;" class="font-weight-normal">(You can drag the marker to get the specific location.)</span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="map-search" name="location" value="{{ $service->location }}"> <br>
                                        <div id="map-canvas"></div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-label font-weight-bold my-50">Latitude</div>
                                                    <input type="text" name="latitude" value="{{ $service->latitude }}" class="form-control latitude">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-label font-weight-bold my-50">Longitude</div>
                                                    <input type="text" name="longitude" value="{{ $service->longitude }}" class="form-control longitude">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-footer float-right">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
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
                            url: `/service/remove_image/${service_id}/${key_id}`,
                            success: function (response) {

                                if(response.status == 201) {
                                    Swal.fire(
                                        "Removed!",
                                        "Record has been removed.",
                                        "success"
                                    ).then((result) => {
                                        location.reload();
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