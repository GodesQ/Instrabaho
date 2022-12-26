@extends('layout.user-layout')

@section('title')
    TRACK PROJECT
@endsection

@section('content')

@if (Session::get('fail'))
    @push('scripts')
        <script>
            toastr.error('{{ Session::get("fail") }}', 'Failed');
        </script>
    @endpush
@endif

<div class="page-wrapper">
    <div class="page-content">
        <div class="page-body">

            <div class="container d-flex justify-content-center align-items-center flex-column">
                <div class="my-2">
                    <a href="/employer/projects/ongoing" class="btn btn-secondary">Back to Ongoing Projects</a>
                </div>
                <div class="card" style="width: 350px !important;">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <img src="../../../images/logo/main-logo.png" alt="Instrabaho Logo" style="width: 70%;" class="img-responsive">
                            <form action="{{ route('contract.post_validate_code') }}" method="post" class="my-2">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="code" id="code" class="form-control" placeholder="Type the given code here.">
                                </div>
                                <button class="btn btn-primary btn-block">Send Code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

