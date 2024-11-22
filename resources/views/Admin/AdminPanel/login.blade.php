@extends('FrontEnd.loginMaster')
@section('title')
    Admin Panel Login
@endsection
@section('content')
<section class="container">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <form action="{{ route('login') }}" method="POST" 
            style="margin-top:130px; margin-bottom:92px; border: 1px solid #4CAF50; 
            padding: 30px; border-radius: 1%; box-shadow: 5px 7px #888888;">
            @csrf
            <h3 class="text-center" style="color:#4CAF50;"><b>Admin Panel Login</b></h3>
            <br>
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
                    <input type="checkbox" name="remember" checked 
                        {{ old('remember') ? 'checked' : '' }}> Remember Me
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="col-lg-12 btn btn-success loginbtn">Login</button>
            </div>
            <br>
            <br>
            <div class="form-group">
                @if (Route::has('password.request'))
                    <u><a href="{{ route('password.request') }}" style="color:#4CAF50;">
                        Forgot Your Password ?</a>
                    </u>
                @endif
            </div>
            {{--  <div class="form-group">
                Not Register Yet ? 
                <u><a href="{{ route('register') }}" style="color:#4CAF50;">
                    Go to Registration</a>.
                </u>
            </div>  --}}
            
        </form>
    </div>
    <div class="col-lg-4"></div>
</section>

@endsection
