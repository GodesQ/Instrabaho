@extends('layout.user-layout')

@section('content')
    @if (Session::get('success'))
        @push('scripts')
            <script>
                toastr.success('{{ Session::get('success') }}', 'Success');
            </script>
        @endpush
    @endif
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Freelancer</th>
                                        <th>Hourly Rate</th>
                                        <th>Member Since</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($followed_freelancers as $followed_freelancer)
                                        <tr style="border-bottom: 1px solid #e3ebf3;">
                                            <td width="40%">
                                                <div class="d-flex justify-content-start align-items-center"
                                                    style="gap: 10px;">
                                                    @if ($followed_freelancer->freelancer->user->profile_image)
                                                        <img style="border-radius: 50px;"
                                                            src="../../../images/user/profile/{{ $followed_freelancer->freelancer->user->profile_image }}"
                                                            alt="" width="40">
                                                    @else
                                                        <img style="border-radius: 50px;"
                                                            src="../../../images/user-profile.png" alt=""
                                                            width="40">
                                                    @endif
                                                    <div>
                                                        <div class="font-weight-bold">
                                                            {{ $followed_freelancer->freelancer->display_name }}</div>
                                                        <div>{{ $followed_freelancer->freelancer->tagline }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($followed_freelancer->freelancer->hourly_rate, 2) }}</td>
                                            <td class="40%">
                                                {{ date_format(new DateTime($followed_freelancer->freelancer->created_at), 'F d, Y') }}
                                            </td>
                                            <td>
                                                <a href="/freelancer/view/{{ $followed_freelancer->freelancer->display_name }}"
                                                    class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i></a>
                                                <a href="/follow_freelancer/view/{{ $followed_freelancer->freelancer->id }}"
                                                    class="btn btn-sm btn-outline-danger"><i class="feather icon-x"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
