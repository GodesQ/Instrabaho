@extends('layout.user-layout')

@section('title')
    PROJECT - {{ $contract->project->title }}
@endsection

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="page-body">

            <div class="container d-flex justify-content-center align-items-center flex-column">
                <div class="my-2">
                    <a href="/freelancer/projects/ongoing" class="btn btn-secondary">Back to Ongoing Projects</a>
                </div>
                <div class="card" style="width: 400px !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <img src="../../../images/logo/main-logo.png" alt="Instrabaho Logo" style="width: 70%;" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
