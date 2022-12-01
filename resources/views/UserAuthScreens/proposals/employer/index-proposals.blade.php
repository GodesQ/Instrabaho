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
                                            <label for="project" class="form-label">Select Project</label>
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
                                            <label for="cost" class="form-label">Proposal Price</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">₱</span>
                                                </div>
                                                <input type="number" min="100" name="onlyNum" class="form-control" id="cost">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
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
                            <div class="proposals">
                                @include('UserAuthScreens.proposals.employer.proposals')
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
        let cost = $('#cost').val();
        let project = $('#project').val();
        $.ajax({
            url: "/employer/proposals/fetch_data?page="+page+'&'+'cost'+cost+'&'+'project_id'+project,
            success: function (data) {
                console.log(data);
                $('.proposals').html(data.view_data);
                $('.protip-container').remove();
            }
        })
    }
})
</script>
@endpush
