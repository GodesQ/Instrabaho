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
            <div class="repeater-default">
                <form action="/store_certificates" enctype="multipart/form-data" method="POST" novalidate>
                    @csrf
                    <div data-repeater-list="certificates">
                        @forelse($freelancer->certificates as $certificate)
                            <div data-repeater-item="">
                                <div class="row">
                                    <div class="form-group mb-1 col-sm-12 col-md-4">
                                        <label for="email-addr">Awards / Certificate</label>
                                        <br>
                                        <input type="hidden" name="old_image" value="{{ $certificate->certificate_image }}">
                                        <input type="text" class="form-control" id="pass" name="certificate" placeholder="Certificate" value="{{ $certificate->certificate }}" required>
                                        <span class="text-danger danger">@error('certificate'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                        <label for="pass">Date</label>
                                        <br>
                                        <input type="date" class="form-control" id="pass" name="certificate_date" placeholder="Date" value="{{ $certificate->certificate_date }}" required>
                                        <span class="text-danger danger">@error('certificate_date'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                        <label for="pass">Image</label>
                                        <br>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="certificate_image" id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                        <span class="text-danger danger">@error('certificate_image'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                        <button type="button" class="btn btn-danger" data-repeater-delete=""> <i class="feather icon-x"></i> Delete</button>
                                    </div>
                                </div>
                                    <div class="">
                                        <img width="100" src="../../../images/freelancer_certificates/{{ $certificate->certificate_image }}" alt=""> <br>
                                    </div>
                                <hr>
                            </div>
                        @empty
                            <div data-repeater-item="">
                                <div class="row">
                                    <div class="form-group mb-1 col-sm-12 col-md-4">
                                        <label for="email-addr">Awards / Certificate</label>
                                        <br>
                                        <input type="text" class="form-control" id="pass" name="certificate" placeholder="Certificate" required>
                                        <span class="text-danger danger">@error('certificate'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                        <label for="pass">Date</label>
                                        <br>
                                        <input type="date" class="form-control" id="pass" name="certificate_date" placeholder="Date" required>
                                        <span class="text-danger danger">@error('certificate_date'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group mb-1 col-sm-12 col-md-3">
                                        <label for="pass">Image</label>
                                        <br>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="certificate_image" id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                        <span class="text-danger danger">@error('certificate_image'){{ $message }}@enderror</span>
                                    </div>
                                    <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                                        <button type="button" class="btn btn-danger" data-repeater-delete=""> <i class="feather icon-x"></i> Delete</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforelse
                    </div>
                    <div class="form-group overflow-hidden">
                        <div class="col-12">
                            <button type="button" data-repeater-create="" class="btn btn-dark btn-solid">
                                <i class="icon-plus4"></i> Add Certificate
                            </button>
                            <button type="submit" class="btn btn-primary btn-solid">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $(document).on("click", ".remove-certificate-image-button", function (e) {
                let key_id = $(this).attr("id");
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
                            url: `/remove_project_image/${service_id}/${key_id}`,
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
