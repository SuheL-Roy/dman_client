@extends('Master.loginlayout')
@section('title')
    Login
@endsection
@section('content')

    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="back-link back-backend">
                    <a href="{{ route('register') }}" class="btn btn-primary">Go to Register</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="back-link back-backend" style="float:right;">
                    <a href="{{ url('/') }}" class="btn btn-primary" style="float:right;">Go Back to Website</a>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container-fluid"><br><br><br>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12"></div>
            <div class="col-md-4 col-md-6 col-sm-6 col-xs-12">
                <div class="text-center m-b-md custom-login">
                    <h3>Merchant Login</h3>
                </div>
                <div class="hpanel">
                    <div class="panel-body">
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label" for="email">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"  
                                        class="form-control @error('email') is-invalid @enderror" autofocus
                                        required autocomplete="null" placeholder="Enter Email">
                                    @error('email')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="control-label" for="password">Password</label>
                                    <input id="password" type="password" name="password" 
                                        autocomplete="current-password" placeholder="Enter Password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-12">
                                    <input class="i- checks" type="checkbox" name="remember" checked 
                                        {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="col-lg-12 btn btn-success loginbtn">Login</button>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                @if (Route::has('password.request'))
                                    <u><a href="{{ route('password.request') }}" style="color:blue;">
                                        Forgot Your Password ?</a>
                                    </u>
                                @endif
                            </div>
                            <div class="form-group">
                                Not Register Yet ? 
                                <u><a href="{{ route('register') }}" style="color:blue;">
                                    Go to Registration</a>.
                                </u>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-2 col-sm-3 col-xs-12"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>Copyright © <script>document.write(new Date().getFullYear());</script>
                    <u><a href="http://www.dokanpos.com" style="color:blue;">
                    {{ config('app.name') }}</a></u> All rights reserved. &nbsp;
                    Develop by <u><a href="http://www.creativesoftware.com.bd" style="color:blue;">
                    Creative Software Ltd</a></u>.
                </p>
            </div>
        </div>
    </div>

@endsection
