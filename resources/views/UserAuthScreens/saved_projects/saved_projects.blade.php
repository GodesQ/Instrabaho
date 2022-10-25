@extends('layout.user-layout')

@section('content')

@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', 'Success');
        </script>
    @endpush
@endif

<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                @forelse($saved_projects as $saved_project)
                    <div class="col-xl-3 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="card-title col-md-7">{{ $saved_project->project->title }}</div>
                                    <div class="col-md-5">
                                        <h4 class="text-right">₱ {{ number_format($saved_project->project->cost, 2) }}</h4>
                                        <div class="text-right">({{ $saved_project->project->project_cost_type }})</div>
                                    </div>
                                </div>
                                <!-- convert the json array ids into model and get to fetch in blade -->
                                @php $saved_project->project->setSkills(json_decode($saved_project->project->skills)) @endphp
                                @php $saved_project->project->getSkills() @endphp
                                <div>
                                    @foreach($saved_project->project->skills_name as $skill)
                                        <div class="badge badge-warning p-50 my-25">{{ $skill->skill_name }}</div>
                                    @endforeach
                                </div>
                                <div style="font-size: 12px; color: gray;" class="my-1">{!! substr($saved_project->project->description, 0, 150) . '...' !!}</div>
                                <div class="d-flex justify-content-end" style="gap: 10px;">
                                    <a href="/project/{{ $saved_project->project->id }}#fr-bid-form" class="btn btn-sm btn-primary p-50">Send Proposal</a>
                                    <form action="{{ route('saved_project.destroy', $saved_project->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-sm btn-danger p-50"><i class="feather icon-x"></i> Unsaved</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 d-flex justify-content-center align-items-center">
                        <div class="card rounded">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <h3 class="text-center my-1">No Records of Saved Projects</h3>
                                <img src="../../../images/nothing-found.png" alt="Nothing Found" width="200">
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            {!! $saved_projects->links() !!}
        </div>
    </div>
</div>
@endsection

