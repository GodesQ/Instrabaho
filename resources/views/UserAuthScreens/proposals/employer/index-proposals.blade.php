@extends('layout.user-layout')

@section('title', 'Employer Proposals')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="baseProposal-tab" data-toggle="tab" aria-controls="tabProposal"
                                href="#tabProposal" role="tab" aria-selected="true">
                                Proposals</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="baseIcon-tab12" data-toggle="tab" aria-controls="tabIcon12" href="#tabIcon12" role="tab" aria-selected="false">Submitted Offers</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div class="tab-pane active" id="tabProposal" role="tabpanel" aria-labelledby="baseProposal-tab">
                            <div class="row">
                                <div class="col-xl-4 col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-title">Filter Projects Proposals</div>
                                            <form action="#" class="form" id="filter-project-form" method="POST">
                                                <div class="form-group">
                                                    <label for="project" class="form-label font-weight-bold">Select
                                                        Project</label>
                                                    <select name="project" id="project" class="select2">
                                                        <option value="">Select Project</option>
                                                        @forelse ($projects as $project)
                                                            <option value="{{ $project->id }}">{{ $project->title }}
                                                            </option>
                                                        @empty
                                                            <option value="">No Projects Found</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="form-label font-weight-bold">Type</label>
                                                    <select name="type" id="type" class="select2">
                                                        <option value="offer">Offers</option>
                                                        <option value="proposal">Proposals</option>
                                                    </select>
                                                </div>
                                                {{-- <div class="form-group">
                                                    <label for="cost" class="form-label font-weight-bold">Proposal Price</label>
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 my-50">
                                                            <label for="cost" class="form-label">Min</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">₱</span>
                                                                </div>
                                                                <input type="number" min="100" name="min" class="form-control" id="min">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-12 col-lg-12 my-50">
                                                            <label for="cost" class="form-label">Max</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">₱</span>
                                                                </div>
                                                                <input type="number" min="100" name="max" class="form-control" id="max">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">.00</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"></div>
                                                    </div>
                                                    <input type="hidden" name="page" id="page_count" value="1">
                                                </div> --}}
                                                <div class="form-footer float-right">
                                                    <button class="btn btn-warning">Find</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-12">
                                    <div class="proposals card">
                                        <div class="card-body">
                                            @include('UserAuthScreens.proposals.employer.proposals')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabIcon12" role="tabpanel" aria-labelledby="baseIcon-tab12">
                            <p>Sugar plum tootsie roll biscuit caramels. Liquorice brownie pastry cotton candy oat cake
                                fruitcake jelly chupa chups. Pudding caramels pastry powder cake soufflé wafer caramels.
                                Jelly-o pie cupcake.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            let url_string = location.href;
            let url = new URL(url_string);
            var action = url.searchParams.get("act");
            if (action == 'offers') {
                $('#baseProposal-tab').click();
            }
        });

        $(document).ready(function() {

            $(document).on('click', '.pagination .page-item a', function(event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                $('#page_count').val(page);
                fetchProposals(page);
            })

            $(document).on('submit', '#filter-project-form', function(event) {
                event.preventDefault();
                fetchProposals(1);
            })

            function fetchProposals(page) {

                let errors = [];
                // validation
                if (min > max) errors.push('It shows that the minimum cost is greater than maximum cost');
                if (!project) errors.push('Project is required.');

                if (errors.length != 0) return errors.forEach(error => {
                    toastr.warning(error, 'Fail');
                });

                $.ajax({
                    url: "/employer/proposals/fetch_data?page=" + page,
                    success: function(data) {
                        $('.proposals').html(data.view_data);
                        $('.protip-container').remove();
                    }
                })
            }
        })
    </script>
@endpush
