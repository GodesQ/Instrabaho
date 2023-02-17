@extends('layout.user-layout')

@section('title')
    Create Contract - {{ $data->project->title }}
@endsection

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
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <h2 class="my-2 font-weight-bold">Create Contract</h2>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="font-weight-bold">Contract Summary</h3>
                                    <p>Lorem ipsum dolor sit amet adipisicing elit. Beatae, adipisci.</p>
                                    <div class="row p-1 border-bottom">
                                        <div class="col-lg-6">
                                            <h5 class="font-weight-normal primary">Project Cost</h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h6 class="text-lg-right">₱ <span id="project-cost-text"
                                                    class="font-weight-bold">{{ number_format($data->project->cost, 2) }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row p-1 border-bottom align-items-center">
                                        <div class="col-lg-8">
                                            <h5 class="font-weight-normal primary">Convenience Fee </h5>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voleniam sunt
                                                veritatis doloremque magni sit.</p>
                                        </div>
                                        <div class="col-lg-4">
                                            <h6 class="text-lg-right">₱ <span class="font-weight-bold"
                                                    id="convenience-fee-display">50.00</span></h6>
                                        </div>
                                    </div>
                                    <div class="row p-1 border-bottom">
                                        <div class="col-lg-6">
                                            <h5 class="font-weight-normal primary">Total Cost</h5>
                                        </div>
                                        <div class="col-lg-6">
                                            <h6 class="text-lg-right"><span id="total-project-cost-text"
                                                    class="font-weight-bold">₱
                                                    {{ number_format(intval($data->project->cost) - 50, 2) }}</span></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card">
                                <div class="card-body">
                                    <h3 class="font-weight-bold">About Freelancer</h3>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus, quos.</p>
                                    <div class="my-2">
                                        <div class="my-25 border-bottom p-1">
                                            Name : {{ $data->freelancer->user->firstname . " " . $data->freelancer->user->lastname }}
                                        </div>
                                        <div class="my-25 border-bottom p-1">
                                            Display Name : {{ $data->freelancer->display_name }}
                                        </div>
                                        <div class="my-25 border-bottom p-1">
                                            Hourly Rate : ₱ {{ $data->freelancer->hourly_rate }}.00
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="">
                                        <h3 class="font-weight-bold">{{ $data->project->title }}</h3>
                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusamus, quos.</p>
                                        <form action="{{ route('store.contract') }}" method="POST" class="my-2">
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $data->project->id }}">
                                            <input type="hidden" name="proposal_id" value="{{ $data->id }}">
                                            <input type="hidden" name="employer_id" value="{{ $data->employer_id }}">
                                            <input type="hidden" name="freelancer_id" value="{{ $data->freelancer_id }}">
                                            <input type="hidden" name="proposal_type" value="{{ $proposal_type }}">
                                            <div class="form-group">
                                                <label for="cost" class="font-weight-bold">Cost</label>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, labore
                                                    consectetur.</p>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">₱</span>
                                                    </div>
                                                    <input type="number" min="100" name="cost" id="cost"
                                                        class="form-control" value="{{ $data->project->cost }}"
                                                        data-validation-required-message="This field is required"
                                                        aria-invalid="false">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cost_type" class="font-weight-bold">Prefer Payment Type</label>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure, unde!</p>
                                                <select name="cost_type" id="cost_type" class="select2"
                                                    onchange="selectCostType(this)">
                                                    <option value="Fixed">Fixed</option>
                                                    <option value="Hourly">Hourly</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="start_date" class="font-weight-bold">Start Date </label>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, labore
                                                    consectetur.</p>
                                                <input type="date" class="form-control" name="start_date" id="start_date"
                                                    value="{{ $data->project->start_date }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="end_date" class="font-weight-bold">End Date </label>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta, labore
                                                    consectetur.</p>
                                                <input type="date" class="form-control" name="end_date" id="name_date"
                                                    value="{{ $data->project->end_date }}">
                                            </div>
                                            <input type="hidden" name="total_cost" id="total_cost"
                                                value="{{ number_format(intval($data->project->cost) - 50, 2) }}">
                                            <div class="form-footer">
                                                <button class="btn btn-primary">Create Contract</button>
                                            </div>
                                        </form>
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
        $('#cost').on('input', function(e) {
            computeContract(e.target.value);
        })

        function selectCostType(e) {
            if (e.value == 'Hourly') {
                $('#total-project-cost-text').html('Depend on the total hours consume from the project.');
                $('#total_cost').val(0);
            } else {
                let cost_value = $('#cost').val();
                computeContract(cost_value);
            }
        }

        function computeContract(cost) {
            let total_cost = document.querySelector('#total_cost');
            let total_cost_text = document.querySelector('#total-project-cost-text');
            let project_cost_text = document.querySelector('#project-cost-text');

            const convenience_fee = 50;

            // compute project cost
            let total = cost - convenience_fee;

            total_cost.value = total;
            total_cost_text.innerHTML = '₱ ' + Number(total).toFixed(2);
            project_cost_text.innerHTML = Number(cost).toFixed(2);
        }
    </script>
@endpush
