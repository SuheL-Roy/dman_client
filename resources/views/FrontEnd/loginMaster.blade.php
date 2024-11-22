<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} || @yield('title')</title>
    <!-- favicon -->

    @php
        $data = App\Admin\Company::first();
    @endphp

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($data->logo) }}">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!--  font Awesome Css  -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- stylesheet for fonts-->
    <link href="{{ asset('/public/Welcome') }}/fonts/stylesheet.css" rel="stylesheet">
    <!-- Reset css-->
    <link href="{{ asset('/public/Welcome') }}/css/reset.css" rel="stylesheet">
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">

    <!--slick css-->
    <link href="{{ asset('/public/Welcome') }}/css/slick.css" rel="stylesheet">
    <!--  owl-carousel css -->
    <link href="{{ asset('/public/Welcome') }}/css/owl.carousel.css" rel="stylesheet">
    <!--  owl-carousel css -->
    <link href="{{ asset('/public/Welcome') }}/css/animate.css" rel="stylesheet">
    <!--  YTPlayer css For Background Video -->
    <link href="{{ asset('/public/Welcome') }}/css/jquery.mb.YTPlayer.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/public/Welcome') }}/css/meanmenu.css">
    <!--  style css  -->
    <link href="{{ asset('/public/Welcome') }}/css/version-5-slider.css" rel="stylesheet">
    <link href="{{ asset('/public/Welcome') }}/style.css" rel="stylesheet">
    <!--  Responsive Css  -->
    <link href="{{ asset('/public/Welcome') }}/css/responsive.css" rel="stylesheet">
    <!--  Select2 CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />


    <!--  Select2 CDN  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.2.4/select2-bootstrap.css"></script>

    <!--  jquery.min.js  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <!--    bootstrap.min.js-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
        integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous">
    </script>
    <!--    jquery.sticky.js-->
    <script src="{{ asset('/public/Welcome') }}/js/jquery.sticky.js"></script>
    <!--  owl.carousel.min.js  -->
    <script src="{{ asset('/public/Welcome') }}/js/owl.carousel.min.js"></script>
    <!--  jquery.mb.YTPlayer.min.js   -->
    <script src="{{ asset('/public/Welcome') }}/js/jquery.mb.YTPlayer.min.js"></script>
    <!--    slick.min.js-->
    <script src="{{ asset('/public/Welcome') }}/js/slick.min.js"></script>
    <script src="{{ asset('/public/Welcome') }}/js/jquery.meanmenu.js"></script>
    <!--    jquery.nav.js-->
    <script src="{{ asset('/public/Welcome') }}/js/jquery.nav.js"></script>
    <!--jquery waypoints js-->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <!--    jquery counterup js-->
    <script src="{{ asset('/public/Welcome') }}/js/jquery.counterup.min.js"></script>
    <!--    main.js-->
    <script src="{{ asset('/public/Welcome') }}/js/main.js"></script>


    <!--  browser campatibel css files-->
    <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

{{-- <body class="js" style="background-image: url({{ asset('/public/Master/img') }}/banner.jpg);">
    <div id="preloader"></div> --}}
    <body class="js" style="">
        <div id="preloader"></div>    



    <section class="about-us">
        <div class="logo_menu" id="sticker">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-6">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                @php
                                    $data = App\Admin\Company::first();
                                @endphp

                               {{-- <img src="{{ asset($data->logo) }}" alt="logo" width="180" height="50">  --}}
                            </a>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 col-xs-6 col-md-offset-1 col-sm-7 col-lg-offset-1 col-lg-6 mobMenuCol">
                        <nav class="navbar">
                            <ul class="nav navbar-nav navbar-right menu">
                                <li><a href="{{ url('/') }}#home">Home</a></li>
                                <li><a href="{{ url('/') }}#about">About</a></li>
                                <li><a href="{{ url('/') }}#tracking">Service</a></li>
                                <li><a href="{{ url('/') }}#service">Price</a></li>
                                <li><a href="{{ url('/') }}#pricing">Coverage</a></li>
                                <li><a href="{{ url('/') }}#contact">Contact</a></li>
                            </ul>
                        </nav>
                    </div>

                    --}}
                    <div class="col-md-3 col-sm-3 col-xs-4 col-lg-3 signup">
                        <ul class="nav navbar-nav">
                            {{-- @if (Route::has('login'))
                                @auth
                                    <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                    <li><a href="{{ url('/home') }}">Dashboard</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @endif
                                @endauth
                            @endif --}}


                            @if (Auth::user())
                                <a style="height: 40px; width: 100%; font-size: 18px;"
                                    href="{{ route('home') }}"class="btn btn-primary py-2 px-4 d-none d-lg-block">Dashboard</a>
                            @else
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @yield('content')

    <div class="copyright-area">
        <div class="container" >
            {{-- <div class="col-xs-12 col-sm-8 col-md-8 text-left"> --}}
                {{-- <div class="footer-text">
                    <p>
                        Copyright © {{ $data->name }}.</a></u>
                        All Rights Reserved. || Develop by
                        <u><a href="http://www.creativesoftware.com.bd">Creative Software</a></u>.
                    </p>
                </div> --}}
            {{-- </div> --}}
            {{-- <div class="col-xs-12 col-sm-4 col-md-4 text-right">
                <div class="footer-text">
                    <a href="#" class="btn btn-xs"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="btn btn-xs"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="btn btn-xs"><i class="fa fa-linkedin"></i></a>
                    <a href="#" class="btn btn-xs"><i class="fa fa-google-plus"></i></a>
                </div>
            </div> --}}
           
             
        </div>
    </div>
 
</body>

</html>

