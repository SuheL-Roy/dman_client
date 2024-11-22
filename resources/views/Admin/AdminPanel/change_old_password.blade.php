@extends('FrontEnd.loginMaster')
@section('title')
    Change Password
@endsection
@section('content')
<section class="container">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="container">
            @if(session('message'))
            <div class="alert alert-dismissible alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ session('message') }}</strong>
            </div>    
            @endif
        </div>
        <form action="{{ route('change.old.password') }}" method="POST" 
            style="margin-top:150px; margin-bottom:130px; border: 1px solid #4CAF50; 
            padding: 30px; border-radius: 1%; box-shadow: 5px 7px #888888;">
            @csrf
            <h3 class="text-center" style="color:#4CAF50;"><b>Change Password</b></h3>
            <br>
            <div class="row">
                <div class="form-group col-lg-12">
                    <label class="control-label" for="password">Old Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong style="color:red;">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-lg-12">
                    <label class="control-label" for="password">Confirm Old Password</label>
                    <input id="password-confirm" type="password" class="form-control" 
                        name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <br>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-block btn-success">Confirm</button>
            </div>
        </form>
    </div>
    <div class="col-lg-4"></div>
</section>

@endsection
