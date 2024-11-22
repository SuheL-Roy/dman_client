@extends('FrontEnd.loginMaster')
@section('title')
    Reset Password
@endsection
@section('content')
<section class="container">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <form action="{{ route('password.update') }}" method="POST" 
            style="margin-top:120px; margin-bottom:67px; border: 1px solid #4CAF50; 
            padding: 30px; border-radius: 1%; box-shadow: 5px 7px #888888;">
            @csrf
            <h3 class="text-center" style="color:#4CAF50;"><b>Reset Password</b></h3>
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
                    <label class="control-label">Password</label>
                    <input id="password" type="password" name="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        autocomplete="new-password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color:red;">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-lg-12">
                    <label class="control-label">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" 
                        name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-block btn-success">Reset Password</button>
            </div>
        </form>
    </div>
    <div class="col-lg-4"></div>
</section>

@endsection
