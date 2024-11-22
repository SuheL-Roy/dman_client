<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} || Welcome</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/public')}}/Master/img/logo/favicon.ico">
    <!-- Google Fonts
		============================================ -->
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/bootstrap.min.css">
    <!-- Bootstrap CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/font-awesome.min.css">
    <!-- owl.carousel CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/owl.carousel.css">
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/owl.theme.css">
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/owl.transitions.css">
    <!-- animate CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/animate.css">
    <!-- normalize CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/normalize.css">
    <!-- main CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/main.css">
    <!-- morrisjs CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/morrisjs/morris.css">
    <!-- mCustomScrollbar CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- metisMenu CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/metisMenu/metisMenu-vertical.css">
    <!-- calendar CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/calendar/fullcalendar.print.min.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/style.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/responsive.css">
    
</head>

<body>
    {{-- <div class="color-line"></div> --}}
    
    <div class="header-top-area" style="margin-left: -200px;">
        <ul class="nav navbar-nav mai-top-nav header-right-menu" style="float:right;">
            <li class="nav-item dropdown">
                <div class="header-top-menu tabl-d-n">
                    <ul class="nav navbar-nav mai-top-nav">
                        @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link">Home</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            </li>
                            @endif
                        @endauth
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    
    <div class="container-fluid" style="padding-top: 200px;">
        <div class="row">
            <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 text-center login-footer">
                <h1 style="font-size: 90px;">Welcome To {{ config('app.name') }}</h1>
                <p>Copyright © 2019 <a href="#>{{ config('app.name') }}</a>
                  All rights reserved. &nbsp;
                  Develop by <a href="http://www.creativesoftware.com.bd">Creative Software Ltd.
                </p>
            </div>
        </div>
    </div>

    <!-- modernizr JS ============================================ -->
    <script src="{{asset('/public')}}/Master/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- jquery
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/bootstrap.min.js"></script>
    <!-- wow JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/wow.min.js"></script>
    <!-- price-slider JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/jquery-price-slider.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/jquery.meanmenu.js"></script>
    <!-- owl.carousel JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/owl.carousel.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/jquery.scrollUp.min.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/metisMenu/metisMenu.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/metisMenu/metisMenu-active.js"></script>
    <!-- counterup JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/counterup/jquery.counterup.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/counterup/waypoints.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/counterup/counterup-active.js"></script>
    <!-- morrisjs JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/sparkline/jquery.sparkline.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/sparkline/jquery.charts-sparkline.js"></script>
    <!-- calendar JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/calendar/moment.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/calendar/fullcalendar.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/calendar/fullcalendar-active.js"></script>
    <!-- tab JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/tab.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/main.js"></script>
</body>

</html>