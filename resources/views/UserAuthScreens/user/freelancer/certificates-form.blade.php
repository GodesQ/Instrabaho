<div class="card">
    <div class="card-header">
        <h4 class="card-title" id="repeat-form">Awards / Certificate</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="text-right my-1">
                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#large">
                    Add Certificate
                </button>
            </div>
            <div class="modal fade text-left" id="large" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel17" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('freelancer.store_certificates') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">Add Certificate</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group my-1">
                                    <div class="form-label font-weight-bold">Certificate Name</div>
                                    <input type="text" name="certificate" id="certificate" class="form-control">
                                </div>
                                <div class="form-group my-1">
                                    <div class="form-label font-weight-bold">Certificate Date</div>
                                    <input type="date" name="certificate_date" id="certificate_date"
                                        class="form-control">
                                </div>
                                <div class="form-group my-1">
                                    <div class="form-label font-weight-bold">Certificate Attachment <span
                                            style="font-style: italic; font-size: 10px;">(e.g.
                                            jpg,jpeg,png,docx,pdf)</span></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="certificate_image"
                                            id="inputGroupFile01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn grey btn-outline-secondary"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                @forelse ($freelancer->certificates as $certificate)
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-12 border my-50">
                        <div class="row p-50 align-items-center">
                            <div class="col-md-4 col-sm-12">
                                <img style="width: 100%; max-height: 150px; object-fit:cover;"
                                    src="../../../images/freelancer_certificates/{{ $certificate->certificate_image }}"
                                    alt="">
                            </div>
                            <div class="col-md-6 col-sm-12 my-1">
                                <h6 class="font-weight-bold">{{ $certificate->certificate }}</h6>
                                <div>{{ date_format(new DateTime($certificate->certificate_date), 'F d, Y') }}</div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="text-right">
                                    <button id="{{ $certificate->id }}"
                                        class="btn btn-outline-danger remove-certificate-image-button"><i
                                            class="feather icon-x"></i></button>
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <h3 class="text-center">No Certificates Found</h3>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".remove-certificate-image-button", function(e) {
                let certificate_id = $(this).attr("id");
                let service_id = '';
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
                            url: '{{ route('freelancer.remove_certificate') }}',
                            method: 'DELETE',
                            data: {
                                _token: csrf,
                                certificate_id
                            },
                            success: function(response) {
                                if (response.status == 201) {
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
