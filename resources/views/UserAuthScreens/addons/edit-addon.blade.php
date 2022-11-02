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
    <div class="page-header">
        <div class="page-content">
            <div class="container">
                <form method="POST" action="/update_addon">
                    @csrf
                    <input type="hidden" name="id" value="{{ $addon->id }}">
                    <input type="hidden" name="freelancer" value="{{ $addon->user_role_id }}">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Edit Addons</div>
                        </div>
                        <hr>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Title</div>
                                        <input type="text" name="title" class="form-control" id="title" value="{{ $addon->title }}">
                                        <span class="danger text-danger">@error('title'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Price</div>
                                        <input type="number" name="price" class="form-control" value="{{ $addon->price }}" id="price">
                                        <span class="danger text-danger">@error('price'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-label font-weight-bold my-1">Description</div>
                                        <textarea name="description" id="description" cols="30" rows="8" class="form-control">{{ $addon->description }}</textarea>
                                        <span class="danger text-danger">@error('description'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-footer float-right">
                                <button type="submit" class="btn btn-solid btn-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
