<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Merchant Register</title>
    <style>
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
            background: rgba(255, 255, 255, 1);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            width: 900px;
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
            color: white;
        }

        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 15px;
        }

        .form .message a {
            color: #289bb8;
            text-decoration: none;
        }

        .form .register-form {}

        .btn {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            color: #289bb8 !important;
            font-size: 18px;
            text-decoration: none;
            overflow: hidden;
            transition: 0.5s;
            margin-top: 15px;
            letter-spacing: 2px;
        }

        .btn {
            color: #289bb8;
        }

        .btn:hover {
            background: #289bb8;
            color: #fff !important;
            border-radius: 5px;
            box-shadow: 0 0 5px #289bb8, 0 0 25px #289bb8, 0 0 50px #289bb8,
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
            animation-delay: 0.25s;
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
            animation-delay: 0.5s;
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
            animation-delay: 0.75s;
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
            color: #333 !important;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
            -webkit-text-fill-color: #000 !important;
        }

        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        textarea:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
            -webkit-text-fill-color: #000 !important;
        }

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
            border: 1px solid #333 !important;
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

        @media (max-width: 500px) {
            .form input:not([type="checkbox"]) {
                /* width: auto;*/
            }

            .form-control {
                width: 310px !important;
                margin-bottom: 10px;
            }

            .form {
                width: 400px;
                top: 55%;
                padding: 30px;
                left: 50%;
            }

            .row .col-12 {
                padding: 0px 10px;
            }

            .show_password {
                padding-left: 10px;
            }

            .login-page {
                margin: 30px 0px !important;
                height: 1000px;
            }
        }
    </style>
    <link rel="stylesheet" href="my-style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>

<body style="display: flex; align-items: center; justify-content: center">
    <!-- @php $data = App\Admin\Company::first(); @endphp -->
    <div class="login-page">
        <div class="form">
            <form class="register-form" action="{{ route('register') }}" method="POST">
                @csrf
                <h2 class="text-dark main_title">Become a Merchant</h2>
                <div class="row">
                    <input type="hidden" name="role" value="13" />
                    <div class="col-lg-12">
                        <input id="business_name" type="text" name="business_name" placeholder="Business Name"
                            class="@error('business_name') mb-1 @enderror" value="{{ old('business_name') }}"
                            autocomplete="business_name" required />
                        @error('business_name')
                            <div class="text-danger mt-0 d-flex" style="font-weight: normal !important">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <input id="email" type="email" name="email" class="@error('email') mb-1 @enderror"
                            value="{{ old('email') }}" autocomplete="email" placeholder="demo@gmail.com" required />
                        @error('email')
                            <div class="text-danger mt-0 d-flex" style="font-weight: normal !important">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <input id="mobile" type="number" name="mobile" class="@error('mobile') mb-1 @enderror"
                            value="{{ old('mobile') }}" autocomplete="mobile" placeholder="01710000000" minlength="11"
                            maxlength="11" required />
                        @error('mobile')
                            <div class="text-danger mt-0 d-flex" style="font-weight: normal !important">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <input id="name" type="text" name="name" placeholder="Owner Name"
                            class="@error('name') mb-1 @enderror" value="{{ old('name') }}" autocomplete="name"
                            required />
                        @error('name')
                            <div class="text-danger mt-0 d-flex" style="font-weight: normal !important">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <select class="form-control mt-2" name="b_type" id="">
                            <option value="">Select Business Type</option>
                            @foreach ($business as $bus)
                                <option value="{{ $bus->b_type }}">{{ $bus->b_type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <!-- <select name="district" class="form-control mt-2" id="district">
                <option value="">Select District</option>
                <option value="">1</option>
                <option value="">2</option>
              </select> -->
                        <select name="district" class="select picker form-control mt-2" id="district"
                            data-style="btn-info" data-live-search="true" required>
                            <option value="">Select District</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <!-- <select name="area" id="area" class="form-control mt-2 test-area">
                <option value="">Select Area</option>
                <option value="">1</option>
                <option value="">2</option>
              </select> -->
                        <select name="area" id="area" class="form-control test-area mt-2" required>
                            <option value="">Select Area</option>
                            {{-- @foreach ($area as $data)
                <option value="{{ $data->id }}">{{ $data->area }}</option>
                @endforeach --}}
                        </select>
                    </div>
                </div>

                <div class="row my-1">
                    <div class="col-lg-12">
                        <div class="d-flex">
                            <label style="color: grey" class="form-label" for="">Address</label>
                        </div>
                        <textarea class="form-control" name="address" placeholder="address...." cols="30" rows="2"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <input id="password" type="password" name="password"
                            class="@error('password') mb-1 @enderror" placeholder="Password at-least 6 Character"
                            autocomplete="new-password" minlength="6" required />
                        @error('password')
                            <div class="text-danger mt-0 d-flex" style="font-weight: normal !important">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <input id="passwordConfirmation" type="password" class=""
                            placeholder="Re-write Same Password" name="password_confirmation"
                            autocomplete="new-password" minlength="6" required />
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex gap-2">
                        <input type="checkbox" onclick="myFunction()" />
                        <span>Show Password</span>
                    </div>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-between gap-2">
            <div class="d-flex gap-2">
              <input type="checkbox" required/>
              <span>I Agree With Term and Condition</span>
            </div>
          </div> --}}
                <div class="d-flex justify-content-center gap-2">
                    <input type="checkbox" required />
                    <span>I agree with the <a style="text-decoration: none;"
                           target="_blank" href="{{ $data->terms_condition }}">Terms and Conditions.</a></span>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-2">
                </div>

                <button type="submit" class="btn font-22 px-4">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Submit
                </button>
                <p class="message">
                    Already registered?
                    <a class="sign-in" href="{{ route('login') }}">Sign In</a>
                </p>
            </form>
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
        $("#district").change(function() {
            $(".test-area").html(
                '<option value="" disabled selected>' +
                '<div class="spinner-border spinner-border-sm" role="status">' +
                '<span class="sr-only">Loading...</span>' +
                "</div></option>"
            );

            var id = $("#district").val();

            $.ajax({
                url: "{{ route('ajaxdata.coverage_data') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    zone_id: id,
                },
                cache: false,
                success: function(dataResult) {
                    console.log(dataResult);

                    if (dataResult.length != 0) {
                        $(".test-area").empty();
                    }

                    $("#area").html(dataResult);

                    // var resultData = dataResult.data;

                    // $.each(resultData, function(index, row) {

                    //     $('#area').append($('<option>', {
                    //         value: row.id,
                    //         text: row.area
                    //     }));

                    // })
                },
            });
        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var password_confirmation = document.getElementById(
                "passwordConfirmation"
            );
            if (
                x.type === "password" &&
                password_confirmation.type === "password"
            ) {
                x.type = "text";
                password_confirmation.type = "text";
            } else {
                x.type = "password";
                password_confirmation.type = "password";
            }
        }
    </script>
</body>

</html>
