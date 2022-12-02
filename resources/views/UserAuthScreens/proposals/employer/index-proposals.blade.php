@extends('layout.user-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Filter Projects Proposals</div>
                                    <form action="#" class="form" id="filter-project-form" method="POST">
                                        <div class="form-group">
                                            <label for="project" class="form-label font-weight-bold">Select Project</label>
                                            <select name="project" id="project" class="select2">
                                                    <option value="">Select Project</option>
                                                @forelse ($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->title }}</option>
                                                @empty
                                                    <option value="">No Projects Found</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="cost" class="form-label font-weight-bold">Proposal Price</label>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-12">
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
                                                <div class="col-xl-6 col-lg-12">
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
                                        </div>
                                        <div class="form-footer float-right">
                                            <button class="btn btn-warning">Find Proposals</button>
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
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
        let min = $('#min').val();
        let max = $('#max').val();
        let project = $('#project').val();

        let errors = [];

        // validation
        if(min > max) errors.push('It shows that the minimum cost is greater than maximum cost');
        if(!project) errors.push('Project is required.');

        if(errors.length != 0) return errors.forEach(error => {
            toastr.warning(error, 'Fail');
        });

        $.ajax({
            url: "/employer/proposals/fetch_data?page="+page+'&'+'min='+min+'&'+'max='+max+'&'+'project_id='+project,
            success: function (data) {
                $('.proposals').html(data.view_data);
                $('.protip-container').remove();
            }
        })
    }
})
</script>
@endpush
