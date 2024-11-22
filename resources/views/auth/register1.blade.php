@extends('Master.loginlayout')
@section('title')
    Register
@endsection
@section('content')

    {{-- <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="back-link back-backend">
                    <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
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
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            <div class="col-md-6 col-md-6 col-sm-12 col-xs-12">
                <div class="text-center custom-login">
                    <h3>Merchant Registration</h3>
                </div>
                <div class="hpanel">
                    <div class="panel-body">
                        <form method="POST" action="{{ route('register') }}" id="loginForm">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Business Name</label>
                                    <input id="business_name" type="text" name="business_name" placeholder="Business Name"
                                        class="form-control @error('business_name') is-invalid @enderror" 
                                        value="{{ old('business_name') }}" required autocomplete="business_name" autofocus>
                                    @error('business_name')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Owner Name</label>
                                    <input id="name" type="text" name="name" placeholder="Owner Name"
                                        class="form-control @error('name') is-invalid @enderror" 
                                        value="{{ old('name') }}" required autocomplete="name">
                                    @error('name')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                           
                                <div class="form-group col-lg-6">
                                    <label>Email Address</label>
                                    <input id="email" type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" 
                                        value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="demo@gmail.com">
                                    @error('email')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Mobile Number</label>
                                    <input id="mobile" type="number" name="mobile"
                                        class="form-control @error('mobile') is-invalid @enderror" 
                                        value="{{ old('mobile') }}" required autocomplete="mobile"
                                        placeholder="017100000000">
                                    @error('mobile')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                           
                                <div class="form-group col-lg-6">
                                    <label>Password</label>
                                    <input id="password" type="password" name="password" required
                                        class="form-control @error('password') is-invalid @enderror" 
                                        placeholder="Password at least 8 character" autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback help-block small" role="alert">
                                            <strong style="color:red;">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Confirm Password</label>
                                    <input id="password-confirm" type="password" required 
                                        placeholder="Confirm Password" name="password_confirmation" 
                                        class="form-control" autocomplete="new-password">
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Area</label>
                                    <select name="area" class="form-control" required>
                                        <option value="">----- Select Area -----</option>
                                        @foreach ($districts as $district)
                                        <option value="{{ $district->name }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Business Type</label>
                                    <select name="b_type" class="form-control" required>
                                        <option value="">----- Select Business Type -----</option>
                                        @foreach ($business as $bus)
                                        <option value="{{ $bus->b_type }}">{{ $bus->b_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-12">
                                    <input type="checkbox" class="i- checks" checked required>
                                        I Agree with the Terms & Conditions of {{ config('app.name') }}.
                                </div>
                                <div class="form-group col-lg-12 ">
                                    Already Registered ? 
                                    <u><a href="{{ route('login') }}" style="color:blue;">
                                        Go to Login</a>
                                    </u>.
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="col-lg-12 btn btn-success loginbtn">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
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
   