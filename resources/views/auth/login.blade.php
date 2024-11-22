<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        <style>
        /* default css */
        @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Roboto", sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        hr {
            margin: 10px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }

        a {
            text-decoration: none;
        }

        h2 {
            margin-bottom: 0px;
            margin-top: 0px;
        }

        /* css utilities */

        .d-flex {
            display: flex;
            justify-content: space-between;
        }

        .fw-bold {
            font-weight: 600;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-start {
            justify-content: start;
        }

        .justify-end {
            justify-content: end;
        }

        .w-100 {
            width: 100%;
        }

        .d-block {
            display: block;
        }

        /* margins */

        .my-05 {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .my-1 {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .my-2 {
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .my-3 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .mt-0 {
            margin-top: 0px;
        }

        .mt-05 {
            margin-top: 5px;
        }

        .mt-1 {
            margin-top: 10px;
        }

        .mt-2 {
            margin-top: 15px;
        }

        .mt-3 {
            margin-top: 20px;
        }

        .mb-05 {
            margin-bottom: 5px;
        }

        /* typhography css */

        .roboto-light {
            font-family: "Roboto", sans-serif;
            font-weight: 300;
            font-style: normal;
        }

        .roboto-regular {
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .roboto-medium {
            font-family: "Roboto", sans-serif;
            font-weight: 500;
            font-style: normal;
        }

        .roboto-bold {
            font-family: "Roboto", sans-serif;
            font-weight: 700;
            font-style: normal;
        }

        .roboto-black {
            font-family: "Roboto", sans-serif;
            font-weight: 900;
            font-style: normal;
        }

        .text-danger {
            color: darkred;
        }

        .text-light-danger {
            color: red;
        }

        .font-12 {
            font-size: 12px;
        }

        .font-13 {
            font-size: 13px;
        }

        .font-14 {
            font-size: 14px;
        }

        .font-15 {
            font-size: 15px;
        }

        .font-18 {
            font-size: 18px;
        }

        .font-22 {
            font-size: 22px !important;
        }

        /* form styles */

        .form-control {
            width: 100%;
            padding: 10px 20px;
            border: 1px solid gray;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-control:focus {
            outline: 1px solid lightblue;
        }

        .form-label {
            margin: 10px 0px;
        }

        /* gaps */

        .gap-1 {
            gap: 10px;
        }

        .gap-15 {
            gap: 15px;
        }

        .gap-2 {
            gap: 20px;
        }

        /* buttons */

        .btn {
            padding: 10px 30px;
            border: 1px solid green;
            font-size: 16px;
            background: darkgreen;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary {
            background: darkgreen;
            color: white;
        }


        @import url(https://fonts.googleapis.com/css?family=Poppins:300);

        html {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: linear-gradient(#30142b, #2772a1);
        }

        input {
            background-color: transparent !important;
        }

        .login-page {
            width: 400px;
            padding: 8% 0 0;
            margin: auto;
        }

        .form {
            position: relative;
            z-index: 1;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            padding: 40px;
            transform: translate(-50%, -50%);
            background: rgba(255, 555, 255, 1);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
            border-radius: 10px;
        }

        .form input:not([type="checkbox"]) {
            width: 100%;
            padding: 10px 0;
            font-size: 13px;
            color: #000;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            background: transparent;
        }

        h2 {
            color: black;
        }


        .form .message {
            margin: 15px 0 0;
            color: #333;
            font-size: 15px;
        }

        .form .message a {
            color: #289bb8;
            text-decoration: none;
        }

        .form .register-form {
            display: none;
        }

        .btn {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            color: #289bb8 !important;
            font-size: 18px;
            text-decoration: none;
            overflow: hidden;
            transition: .5s;
            margin-top: 15px;
            letter-spacing: 2px
        }

        .btn {
            color: #289bb8;
        }

        .btn:hover {
            background: #289bb8;
            color: #fff !important;
            border-radius: 5px;
            box-shadow: 0 0 5px #289bb8,
                0 0 25px #289bb8,
                0 0 50px #289bb8,
                0 0 100px #289bb8;
        }

        .btn span {
            position: absolute;
            display: block;
        }

        .btn span:nth-child(1) {
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #289bb8);
            animation: btn-anim1 1s linear infinite;
        }

        @keyframes btn-anim1 {
            0% {
                left: -100%;
            }

            50%,
            100% {
                left: 100%;
            }
        }

        .btn span:nth-child(2) {
            top: -100%;
            right: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, transparent, #289bb8);
            animation: btn-anim2 1s linear infinite;
            animation-delay: .25s
        }

        @keyframes btn-anim2 {
            0% {
                top: -100%;
            }

            50%,
            100% {
                top: 100%;
            }
        }

        .btn span:nth-child(3) {
            bottom: 0;
            right: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(270deg, transparent, #289bb8);
            animation: btn-anim3 1s linear infinite;
            animation-delay: .5s
        }

        @keyframes btn-anim3 {
            0% {
                right: -100%;
            }

            50%,
            100% {
                right: 100%;
            }
        }

        .btn span:nth-child(4) {
            bottom: -100%;
            left: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(360deg, transparent, #289bb8);
            animation: btn-anim4 1s linear infinite;
            animation-delay: .75s
        }

        @keyframes btn-anim4 {
            0% {
                bottom: -100%;
            }

            50%,
            100% {
                bottom: 100%;
            }
        }

        .form-control {
            background: transparent !important;
            color: grey !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
            -webkit-text-fill-color: #000 !important;
        }
    </style>
    </style>
    <link rel="stylesheet" href="my-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body style="display:flex; align-items:center; justify-content:center;">
    @php
        $data = App\Admin\Company::first();
    @endphp
    <div class="login-page">
        <div class="form">

            <form class="login-form" action="{{ route('login') }}" method="POST">
                @csrf
                <h2></i>{{ $data->name }} Login </h2>
                <input type="email" name="email" value="{{ old('email') }}" class="@error('email') mb-2 @enderror"
                    placeholder="Enter your Email" id="myInput" required />
                @error('email')
                    <div class="text-danger mt-0 d-flex" style="font-weight: normal !important;">
                        {{ $message }}
                    </div>
                @enderror
                <input id="password" type="password" type="password" name="password" autocomplete="current-password"
                    class="@error('password') mb-2 @enderror" placeholder="Enter Password" placeholder="Password"
                    required />
                @error('password')
                    <div class="text-danger mt-0 d-flex" style="font-weight: normal !important;">
                        {{ $message }}
                    </div>
                @enderror

                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex gap-2">
                        <input type="checkbox" onclick="myFunction()" /> <span class="">Show
                            Password</span>
                    </div>

                    <div class="d-flex gap-2">
                        <a style="text-decoration: none;" class="sign-up"
                            href="{{ route('forget_password_otp') }}">Forget Password</a>
                    </div>
                </div>

                <button type="submit" class="btn font-22 px-4">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Sign in
                </button>
                <p class="message">Not registered? <a class="sign-up" href="{{ route('merchant.register') }}">Create an
                        account</a></p>
            </form>
            <p style="border: 1px solid white;padding:5px;font-size:16px" class="message live-tracking">Live parcel
                tracking? <a href="{{ route('parcel_tracking') }}">Click here</a></p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('.message .sign-up').click(function() {
            //     $('form').animate({
            //         height: "toggle",
            //         opacity: "toggle"
            //     }, "slow");
            //     $('.live-tracking').css('display', 'none');
            //     $('.form').css('width', '900px');

            // });
            // $('.message .sign-in').click(function() {
            //     $('form').animate({
            //         height: "toggle",
            //         opacity: "toggle"
            //     }, "slow");
            //     $('.live-tracking').css('display', 'block');
            //     $('.form').css('width', '400px');
            // });

        });
    </script>
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
</body>

</html>
