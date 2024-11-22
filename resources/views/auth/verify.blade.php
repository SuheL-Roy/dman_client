@extends('Master.loginlayout')
@section('title')
    Password Recovery
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="back-link back-backend">
                    <a href="index.html" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
            <div class="col-md-4 col-md-4 col-sm-4 col-xs-12">
                <div class="text-center ps-recovered">
                    <h3>{{ config('app.name') }} Password Recovery</h3>
                    <p>Please fill the form to recover your password</p>
                </div>
                <div class="hpanel">
                    <div class="panel-body poss-recover">
                        <p>
                            Enter your email address and your password will be reset and emailed to you.
                        </p>
                        <form action="#" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="username">Email</label>
                                <input type="text" placeholder="example@gmail.com" title="Please enter you email adress" required="" value="" name="username" id="username" class="form-control">
                                <span class="help-block small">Your registered email address</span>
                            </div>

                            <button class="btn btn-success btn-block">Reset password</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>Copyright © <script>document.write(new Date().getFullYear());</script>
                    <u><a href="http://www.dokanpos.com">{{ config('app.name') }}</a></u> All rights reserved.
                    &nbsp;
                    Develop by <u><a href="http://www.creativesoftware.com.bd">Creative Software Ltd</u>.</a>
                </p>
            </div>
        </div>
    </div>
    <!-- jquery
		============================================ -->
        <script src="{{asset('/')}}/Master/js/vendor/jquery-1.11.3.min.js"></script>
        <!-- bootstrap JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/bootstrap.min.js"></script>
        <!-- wow JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/wow.min.js"></script>
        <!-- price-slider JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/jquery-price-slider.js"></script>
        <!-- meanmenu JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/jquery.meanmenu.js"></script>
        <!-- owl.carousel JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/owl.carousel.min.js"></script>
        <!-- sticky JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/jquery.sticky.js"></script>
        <!-- scrollUp JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/jquery.scrollUp.min.js"></script>
        <!-- mCustomScrollbar JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="{{asset('/')}}/Master/js/scrollbar/mCustomScrollbar-active.js"></script>
        <!-- metisMenu JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/metisMenu/metisMenu.min.js"></script>
        <script src="{{asset('/')}}/Master/js/metisMenu/metisMenu-active.js"></script>
        <!-- tab JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/tab.js"></script>
        <!-- icheck JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/icheck/icheck.min.js"></script>
        <script src="{{asset('/')}}/Master/js/icheck/icheck-active.js"></script>
        <!-- plugins JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/plugins.js"></script>
        <!-- main JS
            ============================================ -->
        <script src="{{asset('/')}}/Master/js/main.js"></script>
</body>

</html>