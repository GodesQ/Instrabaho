@extends('layout.admin-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="my-1">
                        <a href="/admin/withdrawals" class="btn btn-secondary">Back to Withdrawal List</a>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>Withdrawal Information</h3>
                                    <div class="container rounded py-1 px-2 my-1" style="background: rgb(247, 247, 247);">
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                User :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->user->firstname }} {{ $withdrawal->user->lastname }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                User Email :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->user->email }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Reference No :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->reference_no }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Transaction Code :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction_code }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Type :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->withdrawal_type }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Status :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                @if($withdrawal->status == 'pending')
                                                    <div class="badge badge-warning">{{ $withdrawal->status }}</div>
                                                @else
                                                    <div class="badge badge-primary">{{ $withdrawal->status }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Sub Amount :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                ₱ {{ number_format($withdrawal->sub_amount, 2) }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Total Amount :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                ₱ {{ number_format($withdrawal->total_amount, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                    @if ($withdrawal->withdrawal_type == 'gcash')
                                        <h3>GCASH Information</h3>
                                        <div class="container rounded py-1 px-2 my-1" style="background: rgb(247, 247, 247);">
                                            <div class="row my-1">
                                                <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                    Gcash Number :
                                                </div>
                                                <div class="col-xl-7 col-lg-12">
                                                    +63{{ $withdrawal->type_data->gcash_number }}
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <h3>Transaction Information</h3>
                                    <div class="container rounded py-1 px-2 mt-1" style="background: rgb(247, 247, 247);">
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Transaction Code :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->transaction_code }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Transaction Type :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->transaction_type }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Name of Transaction :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->name_of_transaction }}
                                            </div>
                                        </div>
                                        <div class="row my-1">
                                            <div class="col-xl-5 col-lg-12 font-weight-bold">
                                                Payment Type :
                                            </div>
                                            <div class="col-xl-7 col-lg-12">
                                                {{ $withdrawal->transaction->payment_method }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mt-2">
                                        <input type="hidden" name="withdrawal_id" id="withdrawal_id" value="{{ $withdrawal->id }}">
                                        @if($withdrawal->status != 'paid')
                                            <button data-value="failed" class="btn btn-outline-secondary statusBtn">Change to Failed</button>
                                        @endif
                                        @if($withdrawal->status != 'processing' && $withdrawal->status != 'paid')
                                            <button data-value="processing" class="btn btn-outline-secondary statusBtn">Change to Processing</button>
                                        @endif
                                        @if($withdrawal->status != 'failed' && $withdrawal->status != 'paid')
                                            <button data-value="paid" class="btn btn-secondary statusBtn">Change to Paid</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.statusBtn').on('click', function(e) {
            let data_value = $(this).attr("data-value");
            let csrf = "{{ csrf_token() }}";
            let withdrawal_id = $('#withdrawal_id').val();
                Swal.fire({
                    title: "Change Status",
                    text: "Are you sure you want to change the status?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#000",
                    confirmButtonText: "Yes, change it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).html('Processing...');
                        $.ajax({
                            url: '{{ route("admin.withdrawals.update_status") }}',
                            method: 'PUT',
                            data: {
                                _token: csrf,
                                status: data_value,
                                id: withdrawal_id
                            },
                            success: function (response) {
                                if(response.status) {
                                    $(this).html('Successfully Paid');
                                    Swal.fire(
                                        "Success!",
                                        response.message,
                                        "success"
                                    ).then((result) => {
                                        if (result.isConfirmed) {

                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire(
                                        "Failed!",
                                        response.message,
                                        "error"
                                    ).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                }
                            },
                            error: function (xhr) {
                                if(xhr.status == 422) {
                                    let errors = JSON.parse(xhr.responseText).errors;
                                    errors.status.forEach(stat => {
                                        toastr.error(stat, 'Failed');
                                    });
                                }
                            }
                        });
                    }
                });
        })
    </script>
@endpush
