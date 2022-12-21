@forelse ($offers as $offer)
    <div class="row border-bottom p-2">
        <div class="col-md-3" style="font-size: 14px !important;">
            {{ date_format(new DateTime($offer->created_at), "F d, Y") }}
        </div>
        <div class="col-md-4" style="font-size: 20px !important;">
            <a href="/offer/info/{{ $offer->id }}" class="primary">{{ $offer->project->title }}</a>
        </div>
        <div class="col-md-4">
            @if (!$offer->is_freelancer_approve)
                <button type="button" class="btn btn-success ml-1 accept-offer-btn" id="{{ $offer->id }}">Accept Offer</button>
            @endif
            <a href="/offer/info/{{ $offer->id }}?act=message" class="btn btn-primary ml-1">Message</a>
        </div>
    </div>
@empty
    <div>No Proposals Found</div>
@endforelse

@push('scripts')
    <script>
        $('.accept-offer-btn').on('click', function () {
            let id = $(this).attr("id");
            let csrf = "{{ csrf_token() }}";
            Swal.fire({
                title: "Accept Offer",
                text: "Are you sure you want to accept the offer?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, accept it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/offer/accept_offer`,
                        method: 'PUT',
                        data: {
                            _token: csrf,
                            id: id,
                        },
                        success: function (response) {

                            if(response.status) {
                                Swal.fire(
                                    "Updated!",
                                    `${response.message}`,
                                    "success"
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                Swal.fire(
                                    "Failed!",
                                    `${response.message}`,
                                    "error"
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        },
                    });
                }
            });
        })
    </script>
@endpush
