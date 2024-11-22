<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} || @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon
		============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('/public/Welcome')}}/img/HD.png">
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
    <!-- meanmenu icon CSS============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/meanmenu.min.css">
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
    <!-- x-editor CSS
      ============================================ -->
      <link rel="stylesheet" href="{{asset('/public')}}/Master/css/editor/select2.css">
      <link rel="stylesheet" href="{{asset('/public')}}/Master/css/editor/datetimepicker.css">
      <link rel="stylesheet" href="{{asset('/public')}}/Master/css/editor/bootstrap-editable.css">
      <link rel="stylesheet" href="{{asset('/public')}}/Master/css/editor/x-editor-style.css">
    <!-- forms CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/form/all-type-forms.css">
    <!-- normalize CSS
    ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/data-table/bootstrap-table.css">
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/data-table/bootstrap-editable.css">
    <!-- modals CSS
      ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/modals.css">
    <!-- touchspin CSS
      ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/touchspin/jquery.bootstrap-touchspin.min.css">
    <!-- datapicker CSS
    ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/datapicker/datepicker3.css">
    <!-- style CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/style.css">
    <!-- colorpicker CSS
    ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/colorpicker/colorpicker.css">
    <!-- select2 CSS
    ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/select2/select2.min.css">
    <!-- Select Picker Style CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    
    <!-- chosen CSS
    ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/chosen/bootstrap-chosen.css">
    <!-- ionRangeSlider CSS
    ============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/ionRangeSlider/ion.rangeSlider.css">
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/ionRangeSlider/ion.rangeSlider.skinFlat.css">
    <!-- responsive CSS
		============================================ -->
    <link rel="stylesheet" href="{{asset('/public')}}/Master/css/responsive.css">
   
</head>

<body>

    <div class="color-line"></div>
    
    @yield('content')

    <!-- modernizr JS
      ============================================ -->
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
    <!-- tab JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/tab.js"></script>
    <!-- icheck JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/icheck/icheck.min.js"></script>
    <script src="{{asset('/public')}}/Master/js/icheck/icheck-active.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/plugins.js"></script>
    <!-- morrisjs JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/morrisjs/raphael-min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/morrisjs/morris.js"></script>
    <script src="{{asset('/')}}/public/Master/js/morrisjs/morris-active.js"></script>
    <!-- morrisjs JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/sparkline/jquery.sparkline.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/sparkline/jquery.charts-sparkline.js"></script>
    
    <!-- data table JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/data-table/bootstrap-table.js"></script>
    <script src="{{asset('/')}}/public/Master/js/data-table/tableExport.js"></script>
    <script src="{{asset('/')}}/public/Master/js/data-table/data-table-active.js"></script>
    <script src="{{asset('/')}}/public/Master/js/data-table/bootstrap-table-editable.js"></script>
    <script src="{{asset('/')}}/public/Master/js/data-table/bootstrap-editable.js"></script>
    <script src="{{asset('/')}}/public/Master/js/data-table/bootstrap-table-resizable.js"></script>
    <script src="{{asset('/')}}/public/Master/js/data-table/colResizable-1.5.source.js"></script>
    <script src="{{asset('/')}}/public/Master/js/data-table/bootstrap-table-export.js"></script>
    <!--  editable JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/editable/jquery.mockjax.js"></script>
    <script src="{{asset('/')}}/public/Master/js/editable/mock-active.js"></script>
    <script src="{{asset('/')}}/public/Master/js/editable/select2.js"></script>
    <script src="{{asset('/')}}/public/Master/js/editable/moment.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/editable/bootstrap-datetimepicker.js"></script>
    <script src="{{asset('/')}}/public/Master/js/editable/bootstrap-editable.js"></script>
    <script src="{{asset('/')}}/public/Master/js/editable/xediable-active.js"></script>
    <!-- Chart JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/chart/jquery.peity.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/peity/peity-active.js"></script>
    <!-- calendar JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/calendar/moment.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/calendar/fullcalendar.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/calendar/fullcalendar-active.js"></script>
    <!-- touchspin JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/touchspin/touchspin-active.js"></script>
    <!-- colorpicker JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/colorpicker/jquery.spectrum.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/colorpicker/color-picker-active.js"></script>
    <!-- datapicker JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/datapicker/bootstrap-datepicker.js"></script>
    <script src="{{asset('/')}}/public/Master/js/datapicker/datepicker-active.js"></script>
    <!-- input-mask JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/input-mask/jasny-bootstrap.min.js"></script>
    <!-- chosen JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/chosen/chosen.jquery.js"></script>
    <script src="{{asset('/')}}/public/Master/js/chosen/chosen-active.js"></script>
    <!-- Select Picker JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    
    <!-- select2 JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/select2/select2.full.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/select2/select2-active.js"></script>
    <!-- ionRangeSlider JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/ionRangeSlider/ion.rangeSlider.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/ionRangeSlider/ion.rangeSlider.active.js"></script>
    <!-- rangle-slider JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/rangle-slider/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/rangle-slider/jquery-ui-touch-punch.min.js"></script>
    <script src="{{asset('/')}}/public/Master/js/rangle-slider/rangle-active.js"></script>
    <!-- knob JS
    ============================================ -->
    <script src="{{asset('/')}}/public/Master/js/knob/jquery.knob.js"></script>
    <script src="{{asset('/')}}/public/Master/js/knob/knob-active.js"></script>
    <!-- main JS
		============================================ -->
    <script src="{{asset('/public')}}/Master/js/main.js"></script>
</body>

</html>