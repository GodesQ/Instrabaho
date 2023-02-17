@extends('layout.user-layout')

@section('title')
    Review Worker
@endsection

@section('content')
    <style>
        .freelancer-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .review-header {
            padding: 1rem 0;
            border-bottom: 1px solid lightgray;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .review-header-content h4 {
            font-size: 20px;
        }

        .review-content {
            padding: 1.5rem 0;
        }

        .ratings {
            display: flex;
            justify-content: flex-start;
            width: 30%;
            border-radius: 25px;
        }

        .star {
            font-size: 50px;
            cursor: pointer;
        }

        @media (max-width: 450px) {
            .freelancer-image {
                width: 80px;
                height: 80px;
                object-fit: cover;
            }

            .review-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .review-header-content h4 {
                font-size: 15px;
            }
        }
    </style>

    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-body">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="font-weight-medium">Write Review</h2>
                        <button class="btn btn-secondary" onclick="history.back()">Back</button>
                    </div>
                    <div class="card my-1">
                        <div class="card-body">
                            <div class="review-header">
                                <div class="d-flex justify-content-start align-items-center flex-sm-row" style="gap: 10px;">
                                    @if ($contract->freelancer->user->profile_image)
                                        <img class="border-primary freelancer-image"
                                            src="../../../images/user/profile/{{ $contract->freelancer->user->profile_image }}"
                                            alt="">
                                    @else
                                        <img class="border-primary freelancer-image" src="../../../images/user-profile.png"
                                            alt="">
                                    @endif
                                    <div class="review-header-content">
                                        <h4 class="font-weight-bold">{{ $contract->freelancer->user->firstname }}
                                            {{ $contract->freelancer->user->lastname }}</h4>
                                        <h6>{{ $contract->freelancer->tagline }}</h6>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="font-weight-normal">Job Type: <span
                                            class="font-weight-bold text-uppercase">{{ $job_type }}</span></h5>
                                    @if ($job_type == 'project')
                                        <h5 class="font-weight-normal">Job Title: <span
                                                class="font-weight-bold ">{{ $contract->project->title }}</span></h5>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('post-review.freelancer') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="job_type" value="{{ $job_type }}">
                                <input type="hidden" name="job_id" value="{{ $contract->id }}">
                                <input type="hidden" name="reviewer_id" value="{{ $contract->employer_id }}">
                                <input type="hidden" name="freelancer_id" value="{{ $contract->freelancer_id }}">
                                <div class="review-content">
                                    {{-- <div class="rate-container my-25">
                                        <div class="d-md-flex justify-content-start align-items-center">
                                            <h3 class="font-weight-bold">Project Rate :</h3>
                                            <div class="ratings mx-2">
                                                <div class="project-star star" id="1" style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="project-star star" id="2" style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="project-star star" id="3" style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="project-star star" id="4" style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="project-star star" id="5" style="color: rgb(255, 166, 0);">&#9734;</div>
                                            </div>
                                            <input type="hidden" name="rate" id="rate">
                                        </div>
                                    </div> --}}
                                    <div class="rate-container my-25">
                                        <div class="d-md-flex justify-content-start align-items-center">
                                            <h3 class="font-weight-bold">Freelancer Rate : <span class="danger">*</span>
                                            </h3>
                                            <div class="ratings mx-2">
                                                <div class="freelancer-star star" id="1"
                                                    style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="freelancer-star star" id="2"
                                                    style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="freelancer-star star" id="3"
                                                    style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="freelancer-star star" id="4"
                                                    style="color: rgb(255, 166, 0);">&#9734;</div>
                                                <div class="freelancer-star star" id="5"
                                                    style="color: rgb(255, 166, 0);">&#9734;</div>
                                            </div>
                                            <input type="hidden" name="freelancer_rate" id="freelancer_rate">
                                        </div>
                                        <span class="danger text-danger p-1">
                                            @error('freelancer_rate')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <h3 class="font-weight-bold">Review</h3>
                                        <textarea name="review" id="" cols="30" rows="10" class="form-control"
                                            placeholder="Write your review here...">{{ old('review') }}</textarea>
                                        <span class="danger text-danger p-1">
                                            @error('review')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <h3 class="font-weight-bold">Upload Attachment</h3>
                                        <input type="file" name="review_image" class="form-control">
                                    </div>
                                </div>
                                <div class="btn-footer">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // let projects_stars = document.querySelectorAll('.project-star');
        // let rate = document.querySelector('#rate');
        // let currentActiveStar = 0;
        // projects_stars.forEach((star, i) => {
        //     star.onclick = function () {
        //         currentActiveStar = this.id;
        //         rate.value = currentActiveStar;
        //         projects_stars.forEach((star, i) => {
        //             if(currentActiveStar >= i + 1) {
        //                 star.innerHTML = '&#9733;';
        //             } else {
        //                 star.innerHTML = '&#9734;';
        //             }
        //         });
        //     }
        // });

        let freelancer_stars = document.querySelectorAll('.freelancer-star');
        let freelancer_rate = document.querySelector('#freelancer_rate');
        let currentActiveFreelancerStar = 0;
        freelancer_stars.forEach((star, i) => {
            star.onclick = function() {
                currentActiveFreelancerStar = this.id;
                freelancer_rate.value = currentActiveFreelancerStar;
                freelancer_stars.forEach((star, i) => {
                    if (currentActiveFreelancerStar >= i + 1) {
                        star.innerHTML = '&#9733;';
                    } else {
                        star.innerHTML = '&#9734;';
                    }
                });
            }
        });
    </script>
@endsection
