<!DOCTYPE HTML>
<html lang="zxx">

<head>
    <?php
    $title = \App\Models\Setting::first();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/jpg" href="{{ URL::to('/') }}/uploads/{{ $title->logo }}" />
    <title>{{ $title->system_name }}</title>

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Favicon Icon -->
    {{-- <link rel="icon" type="image/png" href="{{asset('assets/img/favcion.png')}}" /> --}}
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}" media="all" />
    <!-- Slick nav CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slicknav.min.css') }}" media="all" />
    <!-- Iconfont CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css') }}" media="all" />
    <!-- Owl carousel CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Popup CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- Main style CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style2.css') }}" media="all" />
    <!-- Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}" media="all" />

    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>

    {{-- popup add --}}
    <?php
    $adds = \App\Models\WebAd::where('ad_type', 'popup')->first();
    ?>
    <div id="popupAdsPannel" class="nothing" style="height:0px">

        <button id="closePopup">
            <i class="fas fa-times"></i>
        </button>
        <a href="{{ $adds->ad_link }}">
            @if (!empty($adds->image))
                <img src="{{ URL::to('/') }}/uploads/ad/{{ $adds->image }}" alt="{{ $adds->ad_type }}"
                    title="{{ $adds->ad_type }}" style="width: 100%; height: 100%" />
            @else
                <img src="{{ URL::to('/') }}/uploads/no.jpeg" alt="" style="width: 100%; height: 100%" />
            @endif
        </a>
    </div>

    <script>
        var clickCounter = parseInt(localStorage.getItem("clickCounter")) || 0;
        var adsData = "<?php echo $adds->show_per_video_category; ?>";
        if (clickCounter == adsData) {
            document.getElementById("popupAdsPannel").classList.add("popup-ads-pannel");
        }
    </script>
    {{-- popup add --}}


    <?php
    $logo = \App\Models\Setting::first('logo');
    ?>

    <header class="header ">
        <div class="header-bg"></div>
        <div class="container">
            <div class="header-area">
                <div class="logo">
                    <a href="{{ url('/frontend') }}">
                        {{-- <img src="{{ asset('assets/img/xflix-logo.png') }}" alt="logo" /> --}}

                        @if (!empty($logo->logo))
                            <img src="{{ URL::to('/') }}/uploads/{{ $logo->logo }}" alt="No Logo" />
                        @else
                            <img src="{{ URL::to('/') }}/uploads/logo.jpg" alt="" />
                        @endif
                    </a>
                </div>
                <div class="header-right">
                    <form action="/frontend/video/filter" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit"><i class="icofont icofont-search"></i></button>
                        <input name="search" type="text" placeholder="Seach Movie" />
                    </form>
                    <ul>
                        <li><a href="{{ url('/frontend') }}">Home</a></li>
                        <li><a class="active" href="{{ url('/frontend/category') }}">Explore</a></li>
                        <li><a href="{{ url('/frontend/video') }}">Videos</a></li>
                        {{-- <li><a href="{{ url('/frontend/video') }}">Live TV</a></li> --}}

                        @if (empty(Auth()->id()))
                            <li><a class="login" href="#" data-toggle="modal"
                                    data-target="#modalLRForm">Login/Registration</a></li>

                        @endif
                        @if (!empty(Auth()->id()))
                            <li>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                        @if (!empty(Auth::user()->image))
                                            <img src="{{ URL::to('/') }}/uploads/user/{{ Auth::user()->image }}"
                                                alt="{{ Auth::user()->name }}" class="header-user-img" style="border-radius: 50%; height:40px;" width="40" />
                                        @else
                                            <img src="{{ URL::to('/') }}/uploads/no.jpeg" class="header-user-img" style="border-radius: 50%; height:40px;" width="40" />
                                        @endif
                                        {{Auth::user()->name}}
                                        {{-- <img src="{{ asset('assets/img/slide4.jpg') }}" alt=""
                                            style="border-radius: 50%" width="40"> --}}
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="/frontend/profile" class="dropdown-item"><i class="fa fa-user mr-3"
                                                aria-hidden="true"></i>
                                            Profile</a>
                                        <a href="{{ url('/frontend/video?type=favourite') }}"
                                            class="dropdown-item"><i class="fa fa-heart mr-3" aria-hidden="true"></i>
                                            Favourite</a>
                                        <a href="/frontend/video?type=history" class="dropdown-item"><i
                                                class="fa fa-history mr-3" aria-hidden="true"></i>
                                            History</a>
                                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i>
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="menu-area">
                    @if (empty(Auth()->id()))
                        <a class="login" href="#" data-toggle="modal"
                            data-target="#modalLRForm">Login/Registration</a>
                    @endif
                    @if (!empty(Auth()->id()))
                        <div class="dropdown text-right">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="{{ asset('assets/img/slide4.jpg') }}" alt="" style="border-radius: 50%"
                                    width="40">
                            </a>
                            <div class="dropdown-menu">
                                <a href="/frontend/profile" class="dropdown-item"><i class="fa fa-user mr-3" aria-hidden="true"></i>
                                    Profile</a>
                                <a href="{{ url('/frontend/video?type=favourite') }}" class="dropdown-item"><i
                                        class="fa fa-heart mr-3" aria-hidden="true"></i> Feborite</a>
                                <a href="/frontend/video?type=history" class="dropdown-item"><i
                                        class="fa fa-history mr-3" aria-hidden="true"></i>
                                    History</a>
                            </div>
                        </div>
                    @endif
                    <div class="responsive-menu"></div>
                    {{-- <form action="#">
                        <button class="srch"><i class="icofont icofont-search"></i></button>
                    </form> --}}
                    <div class="mainmenu">

                        <ul id="primary-menu">
                            <li><a href="{{ url('/frontend') }}">Home</a></li>
                            <li><a class="active" href="{{ url('/frontend/category') }}">Explore</a></li>
                            <li><a href="{{ url('/frontend/video') }}">Video</a></li>
                            <li><a href="{{ url('/frontend/category') }}">Category</a></li>
                            <li><a href="#">Pages <i class="icofont icofont-simple-down"></i></a>
                                <ul>
                                    <li><a href="blog-details.html">Blog Details</a></li>
                                    <li><a href="movie-details.html">Movie Details</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!--Modal: Login / Register Form-->
    <div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog cascading-modal" role="document">
            <!--Content-->
            <div class="modal-content">
                <!--Modal cascading tabs-->
                <div class="modal-c-tabs">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs tabs-2 light-blue darken-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#panel7" role="tab"><i
                                    class="fas fa-user mr-1"></i>
                                Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#panel8" role="tab"><i
                                    class="fas fa-user-plus mr-1"></i>
                                Register</a>
                        </li>
                    </ul>
                    <!-- Tab panels -->
                    <div class="tab-content">
                        <!--Login tab-->
                        <div class="tab-pane fade in show active" id="panel7" role="tabpanel">
                            <div class="modal-body mb-1">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <img src="{{ asset('assets/img/xflix-logo.png') }}" class="mb-3" alt=""
                                        height="100" width="100"><br>

                                    <div class="md-form form-sm mb-5">
                                        <label data-error="wrong" data-success="right" for="modalLRInput10">
                                            <i class="fas fa-envelope prefix mr-3"></i>
                                            Email
                                        </label>

                                        <input type="email" id="modalLRInput10" name="email"
                                            class="form-control form-control-sm validate">
                                    </div>

                                    <div class="md-form form-sm mb-4">
                                        <label data-error="wrong" data-success="right" for="modalLRInput11">
                                            <i class="fal fa-key mr-3"></i>
                                            Password
                                        </label>

                                        <input name="password" type="password" id="modalLRInput11"
                                            class="form-control form-control-sm validate">
                                    </div>

                                    <div class="text-center mt-2">
                                        <button type="submit" class="btn btn-info">Log in </button>
                                    </div>
                                </form>

                                <p> <a href="#" class="blue-text">Forgot Password?</a></p>
                                {{-- <p>Login With</a></p>

                                <ul class="link">
                                    <li><i class="fab fa-google"></i></li>
                                    <li><i class="fab fa-facebook-f"></i></li>
                                </ul>
                                <p>Need An Account ?</a></p>
                                <p><a href="#" class="blue-text">Register Now</a></p> --}}
                            </div>
                        </div>
                        <!--Login tab-->

                        <!--Registration tab-->
                        <div class="tab-pane fade" id="panel8" role="tabpanel">
                            <div class="modal-body">
                                <img src="{{ asset('assets/img/xflix-logo.png') }}" class="mb-3" alt=""
                                    height="100" width="100"><br>


                                <form id="registrationForm" method="POST" enctype="multipart/form-data">

                                    <div class="md-form form-sm mb-5">
                                        <label data-error="wrong" data-success="right" for="name"> <i
                                                class="fas fa-user mr-3"></i>Name</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control form-control-sm validate">
                                    </div>

                                    <div class="md-form form-sm mb-5">
                                        <label data-error="wrong" data-success="right" for="email"> <i
                                                class="fas fa-envelope prefix mr-3"></i>Email</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control form-control-sm validate">
                                    </div>

                                    <div class="md-form form-sm mb-5">
                                        <label data-error="wrong" data-success="right" for="phone"> <i
                                                class="fas fa-phone-alt mr-3"></i>Phone</label>
                                        <input type="number" id="phone" name="phone"
                                            class="form-control form-control-sm validate">
                                    </div>

                                    <div class="md-form form-sm mb-4">
                                        <label data-error="wrong" data-success="right" for="password"> <i
                                                class="fal fa-key mr-3"></i></i>Password</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-sm validate">
                                    </div>

                                    <div class="text-center mt-2">
                                        <button type="submit" id="registrationStore"
                                            class="btn btn-info">Register</button>
                                    </div>

                                </form>
                                {{-- <p> <a href="#" class="blue-text">Forgot Password?</a></p>
                                <p>Login With</a></p>

                                <ul class="link">
                                    <li><i class="fab fa-google"></i></li>
                                    <li><i class="fab fa-facebook-f"></i></li>
                                </ul>
                                <p>NAlreay Have An Account ?</a></p>
                                <p><a href="#" class="blue-text">Login Now</a></p> --}}

                            </div>
                        </div>
                        <!--Registration tab-->
                    </div>

                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!--Modal: Login / Register Form-->
