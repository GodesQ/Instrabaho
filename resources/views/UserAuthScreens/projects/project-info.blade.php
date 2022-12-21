@extends('layout.user-layout')

@section('title')
    Project - {{ $project->title }}
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="text-right my-1">
                        <a href="/employer/projects" class="btn btn-secondary">Back to Projects</a>
                    </div>
                    <ul class="nav nav-tabs nav-underline no-hover-bg" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="base-tab31" data-toggle="tab" aria-controls="tab31" href="#tab31" role="tab" aria-selected="true">Project Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="base-tab32" data-toggle="tab" aria-controls="tab32" href="#tab32" role="tab" aria-selected="false">Proposals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="base-tab33" data-toggle="tab" aria-controls="tab33" href="#tab33" role="tab" aria-selected="false">Offers</a>
                        </li>

                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div class="tab-pane active" id="tab31" role="tabpanel" aria-labelledby="base-tab31">
                            @include('UserAuthScreens.projects.edit-project')
                        </div>
                        <div class="tab-pane" id="tab32" role="tabpanel" aria-labelledby="base-tab32">
                            @include('UserAuthScreens.proposals.employer.proposals')
                            <input type="hidden" name="page" id="page_count" value="1">
                        </div>
                        <div class="tab-pane" id="tab33" role="tabpanel" aria-labelledby="base-tab33">
                            @include('UserAuthScreens.projects_offers.employer.offers')
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
            if(action == 'offers') {
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
                if(min > max) errors.push('It shows that the minimum cost is greater than maximum cost');
                if(!project) errors.push('Project is required.');

                if(errors.length != 0) return errors.forEach(error => {
                    toastr.warning(error, 'Fail');
                });

                $.ajax({
                    url: "/employer/proposals/fetch_data?page="+page,
                    success: function (data) {
                        $('.proposals').html(data.view_data);
                        $('.protip-container').remove();
                    }
                })
            }
        })
    </script>
@endpush
