@extends('FrontEnd.loginMaster')
@section('title')
    Registration
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
            box-sizing: border-box;
        }

        {{--  body {
      background-color: #f1f1f1;
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
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
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
    </style>
    {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>


    @php
        $business = DB::table('business_types')
            ->orderBy('id', 'DESC')
            ->where('status', 1)
            ->get();
        $districts = DB::table('districts')
            ->orderBy('name', 'asc')
            ->get();
        $slider = DB::table('sliders')
            ->orderBy('id', 'DESC')
            ->where('status', 1)
            ->get();
    @endphp

    <section class="container">
        <div class="col-lg-1"></div>
        <div class="col-lg-10" style="margin-top:76px;">
            <form id="regForm" action="{{ route('register') }}" method="POST">
                @csrf
                <!-- One "tab" for each step in the form: -->
                {{-- <div style="text-align: center; margin-top: -10px">
                    <a href="{{ route('rider.registration') }}" class="btn btn-success">Rider Register</a>
                    <a href="{{ route('agent.registration') }}" class="btn btn-success">Agent Register</a>
                    <br>
                </div> --}}
                <br>
                <h3 class="text-center" style="color: var(--primary);"><b>Registration</b></h3>
                <br>
                <div class="tab">
                    <div class="row">

                        <input type="hidden" name="role" value="13">
                        <p class="col-lg-12">
                            <label>Business Name</label>
                            <input id="business_name" type="text" name="business_name" placeholder="Business Name"
                                class="form-control @error('business_name') is-invalid @enderror"
                                value="{{ old('business_name') }}" required autocomplete="business_name">
                            @error('business_name')
                                <span class="invalid-feedback help-block small" role="alert">
                                    <strong style="color: var(--primary);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p class="col-lg-6">
                            <label>Owner Name</label>
                            <input id="name" type="text" name="name" placeholder="Owner Name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback help-block small" role="alert">
                                    <strong style="color: var(--primary);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p class="col-lg-6">
                            <label>Business Type</label>
                            <select name="b_type" class="form-control" id="b_type" required>
                                <option value=""> Select Business Type </option>
                                @foreach ($business as $bus)
                                    <option value="{{ $bus->b_type }}">{{ $bus->b_type }}</option>
                                @endforeach
                            </select>
                        </p>



                        <p class="col-lg-6">
                            <label>Hub</label>
                            <select name="area" id="area" class="form-control" required>
                                <option value="">--- Select Hub ---</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ $zone->name  }}</option>
                                @endforeach
                            </select>
                        </p>
                        <p class="col-lg-6">
                            <label>District</label>
                            <select name="district" class="select picker form-control" id="district" data-style="btn-info"
                                data-live-search="true" required>
                                <option value=""> ---Select District ---</option>

                            </select>
                        </p>
                        <p class="col-lg-12">
                            <label>Address</label>
                            <textarea name="address" id="address" class="form-control" required></textarea>
                        </p>
                    </div>
                    {{--  <p><input placeholder="Last name..." oninput="this.className = ''" name="lname"></p>  --}}

                </div>
                <div class="tab">
                    <div class="row">
                        <p class="col-lg-12">
                            <label>Email Address</label>
                            <input id="email" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required autocomplete="email" placeholder="demo@gmail.com">
                            @error('email')
                                <span class="invalid-feedback help-block small" role="alert">
                                    <strong style="color: var(--primary);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p class="col-lg-12">
                            <label>Mobile Number</label>

                            <input id="mobile" type="text" name="mobile" max="11"
                                class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}"
                                required autocomplete="mobile" maxlength="11" minlength="11" placeholder="01710000000">
                            @error('mobile')
                                <span class="invalid-feedback help-block small" role="alert">
                                    <strong style="color: var(--primary);">{{ $message }}</strong>
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
                                    <strong style="color: var(--primary);">{{ $message }}</strong>
                                </span>
                            @enderror
                        </p>
                        <p class="col-lg-6">
                            <label>Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                placeholder="Re-write Same Password" name="password_confirmation"
                                autocomplete="new-password" minlength="6" required>
                        </p>
                        <p class="col-lg-6">
                            <label><input id="show" type="checkbox" onclick="myFunction()" /></label><label
                                for="show">&nbsp;Show Password</label>
                        </p>

                    </div>

                </div>
                {{-- <div class="tab">
                <div class="row">
                    <p class="col-lg-12">
                        <label>Payment Type</label>
                        <Select onchange="showhideForm(this.value);" id="p_type" class="form-control">
                            <option value="">Select Payment Type</option>
                            <option value="Bank">Bank</option>
                            <option value="Bkash">Bkash</option>
                        </Select>
                    </p>
                    
                    <p class="col-lg-12" id="Bkash1" style="display:none">
                        <label>Account Type</label>
                        <Select name="bkash_account" id="bkash_account" class="form-control">
                            <option value="">Select Account Type</option>
                            <option value="Agent">Agent</option>
                            <option value="Personal">Personal</option>
                        </Select>
                    <p class="col-lg-12" id="Bkash2" style="display:none">
                        <label>Number</label>
                        <input type="number" name="bkash_number" id="bkash_number"
                            class="form-control" minlength="11" maxlength="11"/>
                    </p>

                    <p class="col-lg-6" id="Bank1" style="display:none">
                        <label>Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" class="form-control"/>
                    </p>
                    <p class="col-lg-6" id="Bank2" style="display:none">
                        <label>Branch Name</label>
                        <input type="text" name="branch_name" id="branch_name" class="form-control"/>
                    </p>
                    <p class="col-lg-6" id="Bank3" style="display:none">
                        <label>Account Holder Name</label>
                        <input type="text" name="account_holder_name" id="account_holder" class="form-control"/>
                    </p>
                    <p class="col-lg-6" id="Bank4" style="display:none">
                        <label>Account Type</label>
                        <select name="account_type" class="form-control" id="account_type">
                            <option value=""> Select Account Type </option>
                            <option value="CURRENT">CURRENT</option>
                            <option value="SAVING">SAVING</option>
                            <option value="AWCDI">AWCDI</option>
                            <option value="SND">SND</option>
                            <option value="STD">STD</option>
                            <option value="AWCA">AWCA</option>
                        </select>
                    </p>
                    <p class="col-lg-6" id="Bank5" style="display:none">
                        <label>Account Number</label>
                        <input type="text" name="account_number" id="account_number" class="form-control"/>
                    </p>
                    <p class="col-lg-6" id="Bank6" style="display:none">
                        <label>Routing Number</label>
                        <input type="text" name="routing_number" id="routing_number" class="form-control"/>
                    </p>
                </div>
            </div> --}}
                <br>
                <div>
                    <button class="col-lg-4 btn btn-success" type="button" id="nextBtn" onclick="nextPrev(1)"
                        style="float:right;">Next</button>
                    <button class="col-lg-4 btn btn-primary" type="button" id="prevBtn" onclick="nextPrev(-1)"
                        style="float:right;">Previous</button>
                </div>
                <!-- Circles which indicates the steps of the form: -->
                <div style="text-align:center;margin-top: 54px;">
                    <span class="step"></span>
                    <span class="step"></span>
                    {{-- <span class="step"></span> --}}
                </div>
            </form>
        </div>
        <div class="col-lg-1"></div>
    </section>

    <script>
        $('#area').change(function() {

            $('#district').empty();
            $('#district').append($('<option>', {
                value: '',
                text: '-----Select District------'
            }));

            var zone_id = $('#area :selected').val();

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

    <script type="text/javascript">
        function showhideForm(showform) {
            if (showform == "Bank") {
                document.getElementById("Bank1").style.display = 'block';
                document.getElementById("Bank2").style.display = 'block';
                document.getElementById("Bank3").style.display = 'block';
                document.getElementById("Bank4").style.display = 'block';
                document.getElementById("Bank5").style.display = 'block';
                document.getElementById("Bank6").style.display = 'block';
                document.getElementById("Bkash1").style.display = 'none';
                document.getElementById("Bkash2").style.display = 'none';
            }
            if (showform == "Bkash") {
                document.getElementById("Bank1").style.display = 'none';
                document.getElementById("Bank2").style.display = 'none';
                document.getElementById("Bank3").style.display = 'none';
                document.getElementById("Bank4").style.display = 'none';
                document.getElementById("Bank5").style.display = 'none';
                document.getElementById("Bank6").style.display = 'none';
                document.getElementById("Bkash1").style.display = 'block';
                document.getElementById("Bkash2").style.display = 'block';
            }
            if (showform == "") {
                document.getElementById("Bank1").style.display = 'none';
                document.getElementById("Bank2").style.display = 'none';
                document.getElementById("Bank3").style.display = 'none';
                document.getElementById("Bank4").style.display = 'none';
                document.getElementById("Bank5").style.display = 'none';
                document.getElementById("Bank6").style.display = 'none';
                document.getElementById("Bkash1").style.display = 'none';
                document.getElementById("Bkash2").style.display = 'none';
            }
        }
    </script>

    {{--  <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>  --}}

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // New Mahdi Function 

            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
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