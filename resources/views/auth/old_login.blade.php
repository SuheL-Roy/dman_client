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

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins-Regular";
            color: #333;
            font-size: 13px;
            margin: 0;
        }

        input,
        textarea,
        select,
        button {
            font-family: "Poppins-Regular";
            color: #333;
            font-size: 13px;
        }

        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        ul {
            margin: 0;
        }

        img {
            max-width: 100%;
        }

        ul {
            padding-left: 0;
            margin-bottom: 0;
        }

        a:hover {
            text-decoration: none;
        }

        :focus {
            outline: none;
        }

        .wrapper {
            min-height: 100vh;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
        }

        .inner {
            padding: 20px;
            background: #fff;
            max-width: 850px;
            margin: auto;
            display: flex;
        }

        .inner .image-holder {
            width: 50%;
            margin-top: 130px;

        }

        .inner .image-holder img {
            object-fit: cover;

        }

        .inner form {
            width: 50%;
            padding-top: 36px;
            padding-left: 45px;
            padding-right: 45px;
        }

        .inner h3 {
            text-transform: uppercase;
            font-size: 25px;
            font-family: "Poppins-SemiBold";
            text-align: center;
            margin-bottom: 28px;
        }

        .form-groups {
            display: flex;
        }



        button {
            border: none;
            width: 124px;
            height: 51px;
            margin: auto;
            margin-top: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            background: #333;
            font-size: 15px;
            color: #fff;
            vertical-align: middle;
            -webkit-transform: perspective(1px) translateZ(0);
            transform: perspective(1px) translateZ(0);
            -webkit-transition-duration: 0.3s;
            transition-duration: 0.3s;
        }
    </style>

    <section class="container">

        <div class="wrapper">

            <div class="inner"
                style="margin-top:120px; margin-bottom:67px; border: 1px solid var(--primary); 
            padding: 30px; border-radius: 1%; box-shadow: 6px 7px var(--primary); background-color:white; ">

                @php
                    $data = App\Admin\Company::first();
                @endphp
                <form action="{{ route('login') }}" method="POST">
                    @csrf



                    <h3>{{ $data->name }} Login</h3>

                    <div class="form-group">
                        <label class="control-label" for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" autofocus required autocomplete="null"
                            placeholder="Enter Email">
                        @error('email')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color: var(--primary);">{{ $message }}</strong>
                            </span>
                        @enderror
                        @if (session('status'))
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color: var(--primary);">{{ session('status') }}</strong>
                            </span>
                        @endif
                        @php
                            Illuminate\Support\Facades\Session::forget('status');
                        @endphp
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label>
                        <input id="password" type="password" name="password" autocomplete="current-password"
                            placeholder="Enter Password" class="form-control @error('password') is-invalid @enderror"
                            required>
                        @error('password')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color: var(--primary);">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="checkbox" style="display:flex;">
                        <label style="padding-right: 75px; display:inline-block;"><input type="checkbox"
                                onclick="myFunction()">Show
                            Password</label>
                        <div class="form-group">
                            @if (Route::has('password.request'))
                                <u>
                                    <a href="{{ route('mobile.otp.send.forget') }}" style="color: var(--primary);">
                                        Forgot Your Password ?</a>
                                </u>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>


                    <p class="text-center" style="margin-top: 30px; font-size:18px;">
                        Go to Registration? <a href="{{ route('merchant.register') }}">Sign
                            Up</a>

                    </p>

                </form>


                <div class="image-holder">
                    <img src="{{ asset('/public/photo/baner.png') }}" alt="" width="400" height="300">
                    <p class="" style="margin-top: 30px; font-size:18px;display:inline-block">
                        Live Percel Tracking? <a href="{{ route('parcel_tracking') }}">Click
                            Here</a></span>

                    </p>

                </div>


            </div>

        </div>
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
