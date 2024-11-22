@extends('FrontEnd.loginMaster')
@section('title')
Login
@endsection
@section('content')
<style>
    .btn-success {
        color: #fff;
        background-color: var(--primary);
        border-color: var(--primary);
    }

    button:hover {
        color: #111110 !important;
        background: var(--scolor) !important;
        text-decoration: none;
    }

</style>
<section class="container">
    <div class="col-lg-4" >
        <form action="{{ route('login') }}" method="POST" style="margin-top:120px; margin-bottom:67px; border: 1px solid var(--primary); 
            padding: 30px; border-radius: 1%; box-shadow: 6px 7px var(--primary); background-color:white; ">
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
            @csrf
            <h3 class="text-center" style="color: var(--primary);"><b>Login</b></h3>
            <br>
            <div class="row">
                <div class="form-group col-lg-12">
                    <label class="control-label" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autofocus required autocomplete="null" placeholder="Enter Email">
                    @error('email')
                    <span class="invalid-feedback help-block small" role="alert">
                        <strong style="color: var(--primary);">{{ $message }}</strong>
                    </span>
                    @enderror
                    @if(session('status'))
                    <span class="invalid-feedback help-block small" role="alert">
                        <strong style="color: var(--primary);">{{ session('status') }}</strong>
                    </span>
                    @endif
                    @php
                    Illuminate\Support\Facades\Session::forget('status');
                    @endphp

                </div>
                <div class="form-group col-lg-12">
                    <label class="control-label" for="password">Password</label>
                    <input id="password" type="password" name="password" autocomplete="current-password" placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                    <span class="invalid-feedback help-block small" role="alert">
                        <strong style="color: var(--primary);">{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group col-lg-12">
                    {{-- <input type="checkbox" name="remember" checked {{ old('remember') ? 'checked' : '' }}> Remember Me --}}
                    <input type="checkbox" onclick="myFunction()">Show Password
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="col-lg-12 btn btn-success loginbtn">Login</button>
            </div>
            <br>
            <br>
            <div class="form-group">
                @if (Route::has('password.request'))
                <u>
                    {{-- <a href="{{ route('password.request') }}" style="color: var(--primary);">
                    Forgot Your Password ?</a> --}}
                    <a href="{{ route('mobile.otp.send.forget') }}" style="color: var(--primary);">
                        Forgot Your Password ?</a>
                </u>
                @endif
            </div>
            <div class="form-group">
                Not Register Yet ?
                <u><a href="{{ route('register') }}" style="color: var(--primary);">
                        Go to Registration</a>.
                </u>
            </div>

        </form>
    </div>
    <div class="col-lg-4">


    </div>
    <div class="col-lg-4"></div>
</section>


<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

</script>
@endsection
