@extends('layout.user-layout')

@section('title', 'Create Addon - INSTRABAHO')

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @push('scripts')
                <script>
                    toastr.error('{{ $error }}', 'Error')
                </script>
            @endpush
        @endforeach
    @endif

    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-content">
                <div class="container">
                    <form method="POST" action="/store_addon">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Create Addons</div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-1">Title</div>
                                            <input type="text" name="title" class="form-control" id="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-1">Price</div>
                                            <input type="number" name="price" class="form-control" id="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label font-weight-bold my-1">Description</div>
                                            <textarea name="description" id="" cols="30" rows="8" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-footer float-right">
                                    <button type="submit" class="btn btn-solid btn-primary">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
