@extends('FrontEnd.loginMaster')
@section('title')
    Rider Registration
@endsection
@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        {{--  body {
      background-color: var(--primary);
    }  --}} #regForm {
            background-color: #ffffff;
            margin: 50px auto;
            padding: 40px;
            width: 70%;
            min-width: 300px;
            border: 1px solid var(--primary);
            border-radius: 1%;
            box-shadow: 5px 7px var(--primary);
        }

        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            border: 1px solid var(--primary);
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: var(--primary);
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: var(--primary);
        }

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
        <div class="col-lg-1"></div>
        <div class="col-lg-10" style="margin-top:47px;">
            {{-- <form id="regForm" action="{{ route('register') }}" method="POST"> --}}
            <form id="regForm" action="{{ route('rider.registration') }}" method="POST">
                @csrf
                <h3 class="text-center" style="color:var(--primary);"><b>Rider Registration</b></h3>
                <br>
                <div class="row">
                    <input type="hidden" name="role" value="11">
                    <p class="col-lg-6">
                        <label>Name</label>
                        <input id="name" type="text" name="name" placeholder="Rider Name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required
                            autocomplete="name">
                        @error('name')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p class="col-lg-6">
                        <label>Mobile Number</label>
                        <input id="mobile" type="number" name="mobile"
                            class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}" required
                            autocomplete="mobile" placeholder="01710000000" minlength="11" maxlength="11">
                        @error('mobile')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p class="col-lg-6">
                        <label>Hub</label>
                        <select name="area" id="area" class="js-example-basic-single form-control" required>
                            <option value=""> --- Select Hub --- </option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p class="col-lg-6">
                        <label>District</label>
                        <select name="district" class="form-control" id="district" required>
                            <option value=""> Select District </option>
                        </select>
                    </p>

                    <p class="col-lg-12">
                        <label>Email Address</label>
                        <input id="email" type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                            autocomplete="email" placeholder="demo@gmail.com">
                        @error('email')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p class="col-lg-6">
                        <label>Password</label>
                        <input id="password" type="password" name="password" required
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password at-least 6 Character" autocomplete="new-password" minlength="6">
                        @error('password')
                            <span class="invalid-feedback help-block small" role="alert">
                                <strong style="color:red;">{{ $message }}</strong>
                            </span>
                        @enderror
                    </p>
                    <p class=" col-lg-6">
                        <label>Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control"
                            placeholder="Re-write Same Password" name="password_confirmation" autocomplete="new-password"
                            minlength="6" required>
                    </p>
                    <p class="col-lg-6">
                        <label><input id="show" type="checkbox" onclick="myFunction()" /></label><label
                            for="show">&nbsp;Show Password</label>
                    </p>
                </div>
                <br>
                <button class="btn btn-block btn-success" type="submit">Submit</button>
            </form>
        </div>
        <div class="col-lg-1"></div>
    </section>


    <script>
        $('#area').change(function() {

            $('#district').empty();
            $('#district').append($('<option>', {
                value: '',
                text: ' --- select District --- '
            }));

            var zone_id = $('#area :selected').val();

            // alert(zone_id);
            $.ajax({
                url: "{{ route('ajaxdata.dist') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    zone_id: zone_id
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                    $.each(resultData, function(index, row) {

                        $('#district').append($('<option>', {
                            value: row.d_id,
                            text: row.d_name
                        }));

                    })


                }
            });

        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var y = document.getElementById("password-confirm");
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
@endsection