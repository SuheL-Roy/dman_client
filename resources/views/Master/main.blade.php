<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} || @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    @php
        $data = App\Admin\Company::first();
    @endphp
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($data->logo) }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/font-awesome.min.css">
    <!-- owl.carousel CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/owl.theme.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/owl.transitions.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/animate.css">
    <!-- normalize CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/normalize.css">
    <!-- meanmenu icon CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/meanmenu.min.css">
    <!-- main CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/main.css">
    <!-- morrisjs CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/morrisjs/morris.css">
    <!-- mCustomScrollbar CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <!-- metisMenu CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/metisMenu/metisMenu-vertical.css">
    <!-- calendar CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/calendar/fullcalendar.print.min.css">
    <!-- select2 CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/select2/select2.min.css">
    <!-- chosen CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/chosen/bootstrap-chosen.css">
    <!-- x-editor CSS  -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/editor/select2.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/editor/datetimepicker.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/editor/bootstrap-editable.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/editor/x-editor-style.css">
    <!-- normalize CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/data-table/bootstrap-table.css">
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/data-table/bootstrap-editable.css">
    <!-- modals CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/modals.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/style.css">
    <!-- responsive CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/responsive.css">

    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <!-- touchspin CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/touchspin/jquery.bootstrap-touchspin.min.css">
    <!-- Select Picker Style CDN -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    {{-- <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous"
      /> --}}
    <!-- datapicker CSS -->
    <link rel="stylesheet" href="{{ asset('/public') }}/Master/css/datapicker/datepicker3.css">


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <style>
        .all-content-wrapper {
            margin-left: 236px !important;
        }

        .user_datatable td {
            width: 300px !important;
            /* Adjust the height as needed */
            padding: 5px;
            /* Add padding to improve appearance */
        }
    </style>

</head>

<body>
    @php
        $data = 0;
        if (Auth::check()) {
            if (auth()->user()->role == 12) {
                $date = \Carbon\Carbon::now();

                $today = $date->format('Y-m-d');
                $c_time = $date->format('H:i');

                $data = App\Admin\Scheduler::where('status', 1)
                    ->whereDate('f_date', '<=', $today)
                    ->whereDate('t_date', '>=', $today)
                    ->whereTime('s_time', '<=', $c_time)
                    ->whereTime('e_time', '>=', $c_time)
                    ->count();
            }
        }
    @endphp

    @if ($data > 0)
        {{ App\Http\Controllers\LoginBlockController::logout() }}
        <script>
            window.location.href = "{{ route('login.block.redirect') }}";
        </script>
    @endif


    {{-- SideBar Start --}}
    @include('Master.sidebar')
    {{-- SideBar End --}}

    {{--  <!-- Start Welcome area -->  --}}
    <div class="all-content-wrapper">

        <div class="header-advance-area">

            {{-- Nav Header Start --}}
            @include('Master.header')
            {{-- Nav Header End --}}

            {{--  Mobile Menu start  --}}

            {{--  @include('Master.mobilemenu')  --}}

            {{--  Mobile Menu end   --}}
        </div>

        {{-- Body Start --}}
        @yield('content')

        {{-- Body End --}}

        {{-- Footer Start --}}
        @include('Master.footer')
        {{-- Footer End --}}
    </div>

    <!-- datapicker JS -->
    <script src="{{ asset('/public') }}/Master/js/datapicker/bootstrap-datepicker.js"></script>
    <script src="{{ asset('/public') }}/Master/js/datapicker/datepicker-active.js"></script>

    <!-- select2 JS -->
    <script src="{{ asset('/public') }}/Master/js/select2/select2.full.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/select2/select2-active.js"></script>
    <!-- chosen JS -->
    <script src="{{ asset('/public') }}/Master/js/chosen/chosen.jquery.js"></script>
    <script src="{{ asset('/public') }}/Master/js/chosen/chosen-active.js"></script>
    <!-- modernizr JS -->
    <script src="{{ asset('/public') }}/Master/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- jquery -->
    <script src="{{ asset('/public') }}/Master/js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS -->
    <script src="{{ asset('/public') }}/Master/js/bootstrap.min.js"></script>
    <!-- wow JS -->
    <script src="{{ asset('/public') }}/Master/js/wow.min.js"></script>
    <!-- price-slider JS -->
    <script src="{{ asset('/public') }}/Master/js/jquery-price-slider.js"></script>
    <!-- meanmenu JS -->
    <script src="{{ asset('/public') }}/Master/js/jquery.meanmenu.js"></script>
    <!-- owl.carousel JS -->
    <script src="{{ asset('/public') }}/Master/js/owl.carousel.min.js"></script>
    <!-- wizard JS -->
    <script src="{{ asset('/public') }}/Master/js/wizard/jquery.steps.js"></script>
    <script src="{{ asset('/public') }}/Master/js/wizard/steps-active.js"></script>
    <!-- sticky JS -->
    <script src="{{ asset('/public') }}/Master/js/jquery.sticky.js"></script>
    <!-- scrollUp JS -->
    <script src="{{ asset('/public') }}/Master/js/jquery.scrollUp.min.js"></script>
    <!-- mCustomScrollbar JS -->
    <script src="{{ asset('/public') }}/Master/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS -->
    <script src="{{ asset('/public') }}/Master/js/metisMenu/metisMenu.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/metisMenu/metisMenu-active.js"></script>
    <!-- morrisjs JS -->
    <script src="{{ asset('/public') }}/Master/js/morrisjs/raphael-min.js"></script>
    {{-- <script src="{{asset('/public')}}/Master/js/morrisjs/morris.js"></script>
    <script src="{{asset('/public')}}/Master/js/morrisjs/morris-active.js"></script> --}}
    <!-- morrisjs JS -->
    <script src="{{ asset('/public') }}/Master/js/sparkline/jquery.sparkline.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/sparkline/jquery.charts-sparkline.js"></script>
    <!-- data table JS -->
    <script src="{{ asset('/public') }}/Master/js/data-table/bootstrap-table.js"></script>
    <script src="{{ asset('/public') }}/Master/js/data-table/tableExport.js"></script>
    <script src="{{ asset('/public') }}/Master/js/data-table/data-table-active.js"></script>
    <script src="{{ asset('/public') }}/Master/js/data-table/bootstrap-table-editable.js"></script>
    <script src="{{ asset('/public') }}/Master/js/data-table/bootstrap-editable.js"></script>
    <script src="{{ asset('/public') }}/Master/js/data-table/bootstrap-table-resizable.js"></script>
    <script src="{{ asset('/public') }}/Master/js/data-table/colResizable-1.5.source.js"></script>
    <script src="{{ asset('/public') }}/Master/js/data-table/bootstrap-table-export.js"></script>
    <!--  editable JS -->
    <script src="{{ asset('/public') }}/Master/js/editable/jquery.mockjax.js"></script>
    <script src="{{ asset('/public') }}/Master/js/editable/mock-active.js"></script>
    <script src="{{ asset('/public') }}/Master/js/editable/select2.js"></script>
    <script src="{{ asset('/public') }}/Master/js/editable/moment.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/editable/bootstrap-datetimepicker.js"></script>
    <script src="{{ asset('/public') }}/Master/js/editable/bootstrap-editable.js"></script>
    <script src="{{ asset('/public') }}/Master/js/editable/xediable-active.js"></script>
    <!-- Chart JS -->
    <script src="{{ asset('/public') }}/Master/js/chart/jquery.peity.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/peity/peity-active.js"></script>
    <!-- calendar JS -->
    <script src="{{ asset('/public') }}/Master/js/calendar/moment.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/calendar/fullcalendar.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/calendar/fullcalendar-active.js"></script>
    <!-- plugins JS -->
    <script src="{{ asset('/public') }}/Master/js/plugins.js"></script>
    <!-- main JS -->
    <script src="{{ asset('/public') }}/Master/js/main.js"></script>
    <!-- touchspin JS -->
    <script src="{{ asset('/public') }}/Master/js/touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="{{ asset('/public') }}/Master/js/touchspin/touchspin-active.js"></script>
    <!-- tab JS -->
    <script src="{{ asset('/public') }}/Master/js/tab.js"></script>
    <!-- Select Picker JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    {{-- <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> --}}
    <script script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>


    {!! Toastr::message() !!}






</body>

</html>
