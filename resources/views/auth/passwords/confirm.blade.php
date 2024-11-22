@extends('Master.loginlayout')
@section('title')
    Reset Password
@endsection
@section('content')
<div class="container-fluid">
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
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12"></div>
        <div class="col-md-4 col-md-4 col-sm-6 col-xs-12">
            <div class="text-center m-b-md custom-login">
                <h3>{{ config('app.name') }} {{ __('Confirm Password') }}</h3>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}" id="loginForm">
                        @csrf

                        
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color:red;">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12"></div>
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

@endsection
