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
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <form action="{{ route('otp.login.phone') }}" method="POST">
                    @csrf
                    <div class="">
                        <div style="background-color: #f8f9fa; border: 1px solid lightgray; padding: 80px"
                            class="feature-3 pricing h-100 text-center ">
                            <div
                                style="border: 2px solid rgba(0, 0, 0, 0.6); width: 50px; height: 80px; line-height: 80px; position: relative; border-radius: 50%; margin: 0 auto !important;">
                                <img src="{{ asset('/public/Superend/images/phone_login.png') }}" width="50"
                                    height="45" />
                            </div>
                            <p class="control-label" style="color: black; padding-top: 10px;">Phone Login</p>
                            <div class="row">

                                <select style="float: left; width: 100px; visibility: hidden;" class="form-control">
                                    <option value="+880">BD+88</option>
                                </select>
                                <input type="text" name="mobile_no" class="form-control col-lg-6" autofocus required
                                    autocomplete="null" placeholder="Enter Phone No." minlength="11" maxlength="11" />
                            </div>

                            <div class="form-group text-center">
                                <button
                                    style="margin-top: 30px; width: 150px; background-color: rgb(197, 52, 182); border-color: white; color: white;"
                                    type="submit" class="btn">Sign up</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
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
@endsection
