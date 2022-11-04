
    @if(Session::get('success'))
        @push('scripts')
            <script>
                toastr.success('{{ Session::get("success") }}', 'Success');
            </script>
        @endpush
    @endif

    @if(Session::get('fail'))
        @push('scripts')
            <script>
                toastr.error('{{ Session::get("fail") }}', 'Failed');
            </script>
        @endpush
    @endif

    <div class="card">
        <div class="card-content">
            <div class="card-body">
                @forelse($pending_offers as $key => $pending_offer)
                    <div class="d-flex justify-content-center my-2">
                        <div class="container" style="width: 90% !important;">
                            <div class="d-flex p-2" style="gap: 20px; box-shadow: 1px 0px 20px rgb(0 0 0 / 7%);">
                                <div>
                                    <img class="rounded" src="../../../images/user/profile/{{ $pending_offer->employer->user->profile_image }}" alt="employer_image" style="height: 100px !important;">
                                </div>
                                <div>
                                    <div style="color: #003066;">{{ $pending_offer->employer->user->firstname }} {{ $pending_offer->employer->user->lastname }}</div>
                                    <h3 class="text-secondary">{{ $pending_offer->employer->display_name }}</h3>
                                    <p class="font-weight-light">{{ substr($pending_offer->employer->description, 0, 255) }}...</p>
                                    <div class="text-right mt-2">
                                        <a href="/employer/{{ $pending_offer->employer->user_id }}" class="btn btn-outline-primary">View Employer <i class="fa fa-user"></i></a>
                                        <a href="/service_proposal_information/{{ $pending_offer->id }}" class="btn btn-success">Approved Offer <i class="fa fa-thumbs-up"></i></a>
                                        <a href="/service_proposal_information/{{ $pending_offer->id }}" class="btn btn-primary">View Offer <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse
                {!! $pending_offers->links() !!}
            </div>
        </div>
    </div>

@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on("click", ".approve-btn", function (e) {
            e.preventDefault();
            let id = $(this).attr("id");
            let csrf = "{{ csrf_token() }}";
            Swal.fire({
                title: "Approved Service?",
                text: "Are you sure you want to approved this?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    changeStatus('approved', csrf, id);
                }
            });
        });
    });

    $(document).ready(function () {
        $(document).on("click", ".cancel-btn", function (e) {
            e.preventDefault();
            let id = $(this).attr("id");
            let csrf = "{{ csrf_token() }}";
            Swal.fire({
                title: "Cancel Service?",
                text: "Are you sure you want to cancel this proposal?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    changeStatus('cancel', csrf, id);
                }
            });
        });
    });

    function changeStatus(status, csrf, id) {
        $.ajax({
            url: `/purchased_service/change_status`,
            data: {
                _token: csrf,
                action: status,
                purchased_services: [id]
            },
            method: 'POST',
            success: function (response) {
                Swal.fire(
                    "Update!",
                    "Status update Successfully.",
                    "success"
                ).then((result) => {
                    if (result.isConfirmed) {
                        if(status == 'Approve') {
                            location.href = '/purchased_service/ongoing';
                        }
                    }
                });
            },
        });
    }
</script>
@endpush
