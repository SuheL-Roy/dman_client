@extends('Master.main')
@section('title')
    Add New Parcel
@endsection
<style type="text/css">
    [class^='select2'] {
        border-radius: 0px !important;
    }
</style>
<style>
    .button0 {
        width: 22%;
    }

    @media screen and (max-width: 1500px) and (min-width: 1200px) {
        .row {
            margin-right: -300px !important;
        }

        .order_confirm {
            width: 27rem !important;

        }

        .form-control {
            width: 250px !important;

        }

        .button0 {
            width: 25%;
        }
    }

    @media screen and (max-width: 1199px) and (min-width: 1200px) {
        .row {
            margin-right: -200px !important;
        }

        .order_confirm {
            width: 27rem !important;

        }

        .form-control {
            width: 250px !important;

        }

        .button0 {
            width: 7%;
        }
    }

    @media screen and (max-width: 992px) and (min-width: 766px) {
        .order_confirm {
            width: 27rem !important;

        }

    }

    @media screen and (max-width: 766px)and (min-width: 480px) {
        .button0 {
            width: 90px !important;
            margin-left: 132px;
        }

        .form-control {
            width: 300px !important;
            margin: 0px 25px;
        }

        .col-xs-6 {
            width: 100% !important;
        }
    }

    /* @media screen and (max-width: 991px) {
    

} */
    @media screen and (max-width: 479px)and (min-width: 401px) {

        .form-control {
            width: 300px !important;
            margin: 0px 25px;
        }

        .button0 {

            width: 220px !important;
        }

    }

    @media screen and (max-width: 400px)and (min-width: 300px) {
        .button0 {

            width: 220px !important;
        }

        .form-control {
            width: 290px !important;
            margin: 0px 15px;
        }

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

    .information-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .col-left {
        width: 65%;
        padding: 10px;
        box-sizing: border-box;
    }

    .col-right {
        width: 30%;
        padding: 10px 20px;
        box-sizing: border-box;
        background-color: #f5f5f5;
        max-height: 483px;
        margin-top: 90px;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1),
            0 3px 10px 0 rgba(0, 0, 0, 0.15);
    }
</style>
@section('content')
    <!-- CSS only -->
    <div class="container-fluid">
        @canany(['activeEmployee', 'activeMerchant'])
        @endcanany
        <div class="container-fluid p-4">
            <div class="card">
                {{-- <div class="acrd-header">
                    <h1 class="mt-3 text-center">Add Parcel</h1>
                    <hr>
                </div> --}}

                <div class="card-body">
                    <div class="container" style="background: white; margin-top:15px; border-radius:10px;width:1190px;">
                        <div class="information-wrapper my-3">
                            <div class="col-left">
                                <h2>Add Parcel</h2>
                                <hr />

                                <form class="payment-form" action="{{ route('order.store') }}" method="POST">
                                    @csrf
                                    <input name="tracking_id" type="hidden" id="tracking_id" value="{{ $track }}"
                                        class="form-control" style="border:hidden;">

                                    <div class="d-flex gap-2 my-1 mt-0">
                                        {{-- <div class="w-100"> --}}
                                        {{-- <label for="" class="form-label d-block">Select Marchant</label>
                                  <select name="" id="" class="form-control">
                                    <option value="">Select Marchant</option>
                                    <option value="">1</option>
                                    <option value="">2</option>
                                  </select> --}}
                                        {{-- </div> --}}
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Customer Name</label>
                                            <input type="text" name="customer_name" placeholder="Customer Name"
                                                class="form-control" required />
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Customer Mobile</label>
                                            <input type="text" name="customer_phone" placeholder="Customer Mobile"
                                                class="form-control @error('customer_phone') is-invalid @enderror"
                                                required />
                                            @error('customer_phone')
                                                <span class="invalid-feedback help-block small" role="alert">
                                                    <strong style="color: #ff0000">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 my-1">

                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Address</label>
                                            <input type="text" name="customer_address" placeholder="Address"
                                                class="form-control" />
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Select Weight</label>
                                            <select class="form-control" name="weight" id="weight" required>
                                                <option value=""> --- select weight --- </option>
                                                @foreach ($weights as $weight)
                                                    <option value="{{ $weight->title }}">{{ $weight->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 my-1">
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Select hub</label>
                                            <select onchange="fetch_subcategory_option()" name="hub_id"
                                                id="district_id" class="js-example-basic-single form-control select2"
                                                required>
                                                <option value=""> --- Select Hub --- </option>
                                                @foreach ($hub as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Select Area</label>
                                            <select name="area" class="form-control" id="subcategory_option" required>
                                                <option value=""> Select Area </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 my-1">

                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Selling Price</label>
                                            <input type="text" name="selling_price" placeholder="Selling Price"
                                                class="form-control" />
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Collection(TK)</label>
                                            <input type="text" name="collection" placeholder="Collection Amount"
                                                class="form-control collection" />
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 my-1">

                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Delivery Type</label>
                                            <select name="imp" id="delivery" class="imp form-control" required>
                                                <option value="">Select Delivery Type</option>
                                                <option value="Regular">Regular</option>
                                                <option value="Urgent">Express</option>
                                            </select>
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Product Type</label>
                                            <select id="category" name="product_type" class="form-control"
                                                title="Select Category" required>
                                                <option value=""> Select Product Type </option>
                                                @foreach ($category as $data)
                                                    <option value="{{ $data->name }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="d-flex gap-2 my-1">
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Order ID</label>
                                            <input type="text" id="inputField" name="order_id"
                                                placeholder="Enter Order ID" class="form-control" />
                                            <span id="password-mismatch-message" class="invalid-feedback"></span>
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Remarks</label>
                                            <input type="text" name="remarks" placeholder="Enter remark"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    {{-- <div class="d-flex gap-1 my-1 justify-start align-items-center">
                                        <label for="" class="form-label d-block">Partial Delivery?</label>
                                        <input type="checkbox" placeholder="Enter Order ID" name="is_partial"
                                            value="1"  checked/>
                                        <span style="margin-top:4px;">On</span>
                                    </div> --}}
                                    <div class="d-flex gap-2 my-1">
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Partial Delivery?</label>
                                            <input type="checkbox" placeholder="Enter Order ID" name="is_partial"
                                                value="1" checked />
                                            <span style="margin-top:4px;">On</span>
                                        </div>
                                        <div class="w-100">
                                            <label for="" class="form-label d-block">Exchnage Delivery?</label>
                                            <input type="checkbox" placeholder="Enter Order ID" name="is_exchange"
                                                value="1" checked />
                                            <span style="margin-top:4px;">On</span>
                                        </div>
                                    </div>
                                    <div class="justify-end" style="display: flex; gap:10px;">
                                        <div class="d-flex my-1 justify-end">

                                            <button style="font-size:28px;" type="submit"
                                                class="btn btn-success">Submit</button>
                                            <input type="hidden" class="area">
                                            <input type="hidden" class="hub">
                                            <input type="hidden" class="weight">
                                            <input type="hidden" class="imp">
                                            <input type="hidden" class="merchant_id">

                                        </div>

                                        <div class="d-flex my-1 justify-end">
                                            <a style="font-size:28px;" target="__blank"
                                                href="{{ route('order.latest_collect_print') }}" type="btn"
                                                class="btn btn-primary">Print</a>


                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-right">
                                <div class="location d-flex align-items-center mt-1">
                                    <h2 class="fw-bold font-22">{{ $company->name }}</h2>
                                    {{-- <a href="#" class="text-light-danger">Change</a> --}}
                                </div>
                                {{-- <div class="pickup-address">
                                    <h4 class="mt-1 mb-05 roboto-medium">Your Pickup Address</h4>
                                    <p class="font-13">10 New college road, Mirpur, Dhaka</p>
                                    <hr />
                                </div> --}}
                                <div class="delivery-charge">
                                    <h3 class="roboto-medium font-18 mt-2">
                                        Delivery Charge From Your Pickup Address
                                    </h3>
                                    <div class="d-flex my-1">
                                        <p class="font-15">Cash Collection</p>
                                        <p class="font-15 targetElement">Tk.</p>
                                    </div>
                                    <div class="d-flex my-1">
                                        <p class="font-15">Delivery Charge</p>
                                        <p class="font-15" id="delivery-charge">Tk.0</p>
                                    </div>
                                    <div class="d-flex my-1">
                                        <p class="font-15">COD Charge</p>
                                        <p class="font-15" id="cod">Tk.0</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex my-1">
                                        <p class="font-15">Sub Total</p>
                                        <p class="font-15" id="subtotal">Tk.0</p>
                                    </div>
                                    <hr />
                                    <div class="d-flex my-1">
                                        <p class="font-15 roboto-bold">Total Amount</p>
                                        <p class="font-15 roboto-bold" id="total">Tk.0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#inputField').on('input', function() {
                var inputValue = $(this).val();
                var maxLength = 12;

                if (inputValue.length > maxLength) {
                    // If the input length exceeds the maximum length, truncate the input
                    $(this).val(inputValue.slice(0, maxLength));
                    alert("Maximum character limit exceeded. Only first 12 characters will be saved.");

                }
            });
        });
    </script>
    <script>
        $(document).on('keyup change', '.collection', function() {

            var target_value = $(this).val();




            $('.targetElement').html("Tk." + target_value);

            var delivery = $('.imp').val();

            if (delivery) {
                demo();
            }



            // $('.targetElement').text("Tk." + inputValue);


        });
    </script>

    <script>
        $(document).on('change', '#subcategory_option', function() {

            var selectedValue = $(this).val();



            $.ajax({
                type: "GET",
                url: "{{ route('order.charge_calculation_setup') }}",
                data: {
                    area: selectedValue
                },
                success: function(data) {
                    $('.area').val(data.area.area);
                    // Handle the response data as needed
                    demo();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

    <script>
        $(document).on('change', '#weight', function() {

            var selectedValue = $(this).val();




            $.ajax({
                type: "GET",
                url: "{{ route('order.charge_calculation_setup') }}",
                data: {
                    weight: selectedValue
                },
                success: function(data) {
                    $('.weight').val(data.weight.title);
                    // Handle the response data as needed
                    // demo();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

    <script>
        $(document).on('change', '#delivery', function() {
            var imp = $(this).val();
            $('.imp').val(imp);
            $.ajax({
                type: "GET",
                url: "{{ route('order.charge_calculation') }}",
                data: {
                    area: $('.area').val(),
                    weight: $('.weight').val(),
                    imp: imp,
                    collection: $('.collection').val(),
                    hub_id: $('.hub').val()
                },
                success: function(data) {

                    document.getElementById("delivery-charge").innerHTML = "Tk." + data.delivery_charge;
                    document.getElementById("cod").innerHTML = "Tk." + data.cod;
                    document.getElementById("subtotal").innerHTML = "Tk." + data.total_pay;
                    document.getElementById("total").innerHTML = "Tk." + data.total_pay;


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        function demo() {


            $.ajax({
                type: "GET",
                url: "{{ route('order.charge_calculation') }}",
                data: {
                    area: $('.area').val(),
                    weight: $('.weight').val(),
                    imp: $('.imp').val(),
                    collection: $('.collection').val(),
                    hub_id: $('.hub').val()
                },
                success: function(data) {

                    document.getElementById("delivery-charge").innerHTML = "Tk." + data.delivery_charge;
                    document.getElementById("cod").innerHTML = "Tk." + data.cod;
                    document.getElementById("subtotal").innerHTML = "Tk." + data.total_pay;
                    document.getElementById("total").innerHTML = "Tk." + data.total_pay;


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    <script>
        $('#order_place').on('submit', function(e) {

            if ($("#is_partial").is(":checked")) {
                var is_partial_val = 1;

            } else {
                var is_partial_val = 0;
            }

            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('order.store') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tracking_id': $("#tracking_id").val(),
                    'order_id': $("#order_id").val(),
                    'customer_name': $("#name").val(),
                    'customer_email': $("#email").val(),
                    'customer_phone': $("#phone").val(),
                    'customer_address': $("#address").val(),
                    // 'shop': $("#shop").val(),
                    'area': $("#area").val(),
                    'pickup_date': $("#pickup_date").val(),
                    'pickup_time': $("#pickup_time").val(),
                    'remarks': $("#remarks").val(),
                    'category': $("#category").val(),
                    'product': $("#pro_title").val(),
                    'weight': $("#weight").val(),
                    'collection': $("#collection").val(),
                    'imp': $(".imp").val(),
                    'is_partial': $('#is_partial').is(':checked') == true ? 1 : 0,

                },
                success: function() {

                    location.href = "{{ route('order.preview') }}";


                },
                error: function(error) {
                    console.log(error);
                    alert('Order Not Created');
                }
            });
        });

        $('.imp').change(function() {

            var area = $('#area :selected').val();

            if (area) {
                $.ajax({
                    url: "{{ route('ajaxdata.singleZone') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        area: area
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data['inside'] == 1) {
                            $('.area').val(data['area']);
                        } else {
                            alert('Our outside dhaka One Hour Delivery not avaiable at this moment !');
                            $('.imp').val('Regular');
                        }
                    }
                });

            }

        });
        $('#area').change(function() {

            var imp = $('.imp :selected').val();
            var area = $('#area :selected').val();

            if (imp) {
                $.ajax({
                    url: "{{ route('ajaxdata.singleZone') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        area: area
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(data) {

                        if (data['inside'] == 1) {
                            $('.area').val(data['area']);
                        } else {
                            alert('Our outside dhaka One Hour Delivery not avaiable at this moment !');
                            $('.imp').val('Regular');
                        }
                    }
                });

            }

        });
    </script>
    <script>
        $('#district').change(function() {
            alert(zone_id);
            alert("jkhvdfjgd");
            $('#area').empty();
            $('#area').append($('<option>', {
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
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        function fetch_subcategory_option() {
            var id = $('#district_id').val();

            $('.hub').val(id);

            $("#subcategory_option").html(
                '<option value="" disabled selected>' +
                '<div class="spinner-border spinner-border-sm" role="status">' +
                '<span class="sr-only">Loading...</span>' +
                "</div></option>"
            );
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('fetch.subcategory.value') }}",
                data: {
                    id: id,
                },
                success: function(data) {
                    if (data.length != 0) {

                        $('#subcategory_option').empty();
                    }
                    // $('#subcategory_option').append('<option value="12">Select Area</option>');

                    $.each(data.options, function(index, option) {
                        $('#subcategory_option').append('<option value="' + option.area + '">' +
                            option.area + '</option>');
                    });

                    var firstOptionValue = $('#subcategory_option option:first').val();
                    $('.area').val(firstOptionValue);

                    demo();


                },
            })


        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({})
        })
    </script>
@endsection
