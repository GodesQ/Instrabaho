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
                            <div class="my-2" style="font-size: 20px;">
                                Code : {{ $contract->code }}
                            </div>
                            {{  QrCode::mergeString('/public/images/main-logo.png')->eyeColor(0, 5, 187, 255, 255, 120, 0)->eyeColor(1, 5, 187, 255, 255, 120, 0)->eyeColor(2, 5, 187, 255, 255, 120, 0)->style('round')->size(300)->generate($contract->code); }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
