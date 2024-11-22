@extends('FrontEnd.loginMaster')
@section('title')
    Percel Tracking
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

                <form action="{{ route('live_tracking_parcel') }}" method="GET">
                    @csrf
                    <h3>Live Percel Tracking </h3>

                    <div class="form-group">
                        <label class="control-label" for="email">Please enter your tracking number</label>
                        <input id="number" type="text" name="tracking_number"  class="form-control"
                            placeholder="tracking number" required>
                      
                    </div>
                   

                    <button type="submit" class="btn btn-primary">Load</button>

                    {{-- <p class="text-center" style="margin-top: 30px; font-size:18px;">
                        Go to Login? <a href="{{ route('login') }}">Login</a>
                    </p> --}}

                </form>


                <div class="image-holder">
                    <img src="https://img.freepik.com/free-vector/hand-drawn-flat-design-delivery-concept_23-2149157498.jpg"
                        alt="">
                </div>
            </div>
        </div>
    </section>



    
    
@endsection
