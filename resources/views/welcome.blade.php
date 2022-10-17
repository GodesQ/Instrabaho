@extends('layout.layout') 

@section('content')
@if(Session::get('success'))
    @push('scripts')
        <script>
            toastr.success('{{ Session::get("success") }}', "Login");
        </script>
    @endpush
@endif
<div
    id="exertio-carousal"
    class="carousel slide carousel-fade pointer-event"
    data-bs-ride="carousel"
>
    <ol class="carousel-indicators">
        <li
            data-bs-target="#carouselExampleControls"
            data-bs-slide-to="0"
            class=""
        ></li>
        <li
            data-bs-target="#carouselExampleControls"
            data-bs-slide-to="1"
            class="active"
        ></li>
        <li
            data-bs-target="#carouselExampleControls"
            data-bs-slide-to="2"
            class=""
        ></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img
                class="d-block w-100"
                src="../../../images/slider/Instrabaho_Slider_01_WEB4.png"
                alt="1558"
            />
        </div>
        <div class="carousel-item">
            <img
                class="d-block w-100"
                src="../../../images/slider/Instrabaho_Slider_01_WEB9.jpeg"
                alt="1558"
            />
        </div>
        <div class="carousel-item">
            <img
                class="d-block w-100"
                src="../../../images/slider/Instrabaho_Slider_01_WEB13.png"
                alt="1558"
            />
        </div>
        <div class="carousel-item">
            <img
                class="d-block w-100"
                src="../../../images/slider/Instrabaho_Slider_01_WEB14.png"
                alt="1558"
            />
        </div>
    </div>
    <div class="fr-hero3 hero-slider logoslider" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-xs-12 col-sm-12 col-lg-8 col-md-12">
                    <div class="fr-hero3-main">
                        <div class="fr-hero3-content">
                            <span>Get Started</span>
                            <h1>Trabaho o trabahador?
                                Boss, anong hanap mo?</h1>
                            <p>
                                Instrabaho is a community where you can post a project if you are an employer or you may post service if you are a freelancer. 
                                This initiative is to help people who lose their job during the time of the pandemic.
                            </p>
                        </div>
                        <div class="fr-hero3-srch">
                            <form
                                class="hero-one-form"
                                action="search-page.html"
                            >
                                <ul>
                                    <li>
                                        <div class="form-group">
                                            <input
                                                type="text"
                                                placeholder="What are you look for"
                                                class="form-control"
                                                name="title"
                                            />
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-group">
                                            <select
                                                class="default-select post-type-change"
                                            >
                                                <option value="Choose category">
                                                    Choose category
                                                </option>
                                                <option value="Projects">
                                                    Projects
                                                </option>
                                                <option value="Services">
                                                    Services
                                                </option>
                                                <option value="Employers">
                                                    Employers
                                                </option>
                                                <option value="Freelancer">
                                                    Freelancer
                                                </option>
                                            </select>
                                            <div class="fr-hero3-submit">
                                                <button class="btn btn-theme">
                                                    <i
                                                        class="fas fa-search-plus"
                                                    ></i
                                                    >Search
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <div class="fr-her3-elemnt">
                            Trending Keywords:
                            <a href="search-page.html">React Native</a>
                            <a href="search-page.html">Flutter</a>
                            <a href="search-page.html">Plumber</a>
                            <a href="search-page.html">Artist</a>
                            <a href="search-page.html">Singer</a>
                            <a href="search-page.html">Writer</a>
                        </div>
                        <div class="fr-hero3-video">
                            <a
                                href="https://www.youtube.com/watch?v=C0DPdy98e4c"
                                target="_blank"
                                rel="nofollow"
                                class="popup-video"
                                ><i class="fas fa-play-circle"></i
                            ></a>
                            <div class="fr-hero3-text">
                                <span>Watch Demo</span>
                                <p>Get started in minutes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
