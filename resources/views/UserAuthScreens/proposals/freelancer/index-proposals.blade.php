@extends('layout.user-layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    @forelse ($freelancer->project_proposals as $proposal)
                        <div class="card">
                            <div class="card-body">

                            </div>
                        </div>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
