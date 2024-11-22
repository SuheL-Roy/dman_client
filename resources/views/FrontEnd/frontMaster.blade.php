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
   
    <link rel="shortcut icon" type="image/x-icon" href="{{asset($data->logo)}}">
    
    <!--  bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!--  font Awesome Css  -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!--    stylesheet for fonts-->
    <link href="fonts/stylesheet.css" rel="stylesheet">
    <!-- Reset css-->
    <link href="{{asset('/public/Welcome')}}/css/reset.css" rel="stylesheet">

    <!--slick css-->
    <link href="{{asset('/public/Welcome')}}/css/slick.css" rel="stylesheet">
    <!--  owl-carousel css -->
    <link href="{{asset('/public/Welcome')}}/css/owl.carousel.css" rel="stylesheet">
    <!--  owl-carousel css -->
    <link href="{{asset('/public/Welcome')}}/css/animate.css" rel="stylesheet">
    <!--  YTPlayer css For Background Video -->
    <link href="{{asset('/public/Welcome')}}/css/jquery.mb.YTPlayer.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/public/Welcome')}}/css/meanmenu.css">
    <!--  style css  -->
    <link href="{{asset('/public/Welcome')}}/css/version-5-slider.css" rel="stylesheet">
    <link href="{{asset('/public/Welcome')}}/style.css" rel="stylesheet">
    <!--  Responsive Css  -->
    <link href="{{asset('/public/Welcome')}}/css/responsive.css" rel="stylesheet">

    <!--  browser campatibel css files-->
    
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    
</head>

<body class="js">
    <div id="preloader"></div>
      
        @include('FrontEnd.header')
        
        @yield('content')
        
        @include('FrontEnd.footer')

    <!--  jquery.min.js  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <!--    bootstrap.min.js-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!--    jquery.sticky.js-->
    <script src="{{asset('/public/Welcome')}}/js/jquery.sticky.js"></script>
    <!--  owl.carousel.min.js  -->
    <script src="{{asset('/public/Welcome')}}/js/owl.carousel.min.js"></script>
    <!--  jquery.mb.YTPlayer.min.js   -->
    <script src="{{asset('/public/Welcome')}}/js/jquery.mb.YTPlayer.min.js"></script>
    <!--    slick.min.js-->
    <script src="{{asset('/public/Welcome')}}/js/slick.min.js"></script>
    <script src="{{asset('/public/Welcome')}}/js/jquery.meanmenu.js"></script>
    <!--    jquery.nav.js-->
    <script src="{{asset('/public/Welcome')}}/js/jquery.nav.js"></script>
    <!--jquery waypoints js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
    <!--    jquery counterup js-->
    <script src="{{asset('/public/Welcome')}}/js/jquery.counterup.min.js"></script>
    <!--    main.js-->
    <script src="{{asset('/public/Welcome')}}/js/main.js"></script>
    @stack('js')
</body>

</html>