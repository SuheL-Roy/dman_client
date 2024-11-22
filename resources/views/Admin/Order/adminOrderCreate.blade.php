@extends('Master.main')

@section('title')
    Add Parcel
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
            width: 400px !important;
            margin: 0px 45px;
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

        }

    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@section('content')
    <!-- CSS only -->
    <div class="container-fluid">
        @canany(['activeEmployee', 'activeMerchant'])
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">
                    <h1 class="col-lg-10">Create Order</h1>
                    <hr>
                    <a class="btn btn-success col-lg-1" href="{{ route('csv-file-download') }}">Sample
                        Download</a>
                    <a class="btn btn-info col-lg-1" href="{{ route('csv-file-upload') }}">Import Bulk Order</a>
                </div>
            </div>
        @endcanany

        <hr>
        <div class="container-fluid" style="padding: 40px">
            <div class="card">
                <div class="card-header" style="text-align: center">
                    <h1>Add Parcel</h1>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.admin.store') }}" method="POST">
                        @csrf
                        <input name="tracking_id" type="hidden" id="tracking_id" value="{{ $track }}"
                            class="form-control" style="border:hidden;">


                        <div class="row mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    @cannot('activeEmployee')
                                        <div class="col-md-3">
                                            <label for="validationTooltip01" class="form-label">Merchant *</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="user_id" id="merchant" class="form-control select2"
                                                title="Select Shop" required>
                                                <option value=""> Select Merchant </option>
                                                @foreach ($merchants as $merchant)
                                                    <option value="{{ $merchant->user_id }}">
                                                        {{ $merchant->business_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endcannot
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-3">

                                        <label for="validationTooltip01" class="form-label">Customer Name*</label>
                                    </div>
                                    <div class="col-md-9">

                                        <input name="customer_name" type="text" class="form-control" required
                                            placeholder="Customer Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <div class="col-md-3">

                                        <label for="validationTooltip01" class="form-label">Contact No*</label>
                                    </div>
                                    <div class="col-md-9">

                                        <input name="customer_phone" type="phone" class="form-control " value=""
                                            required autocomplete="phone" placeholder="Customer Mobile" maxlength="11"
                                            minlength="11">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Address *</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="customer_address" class="form-control"
                                            placeholder="Address" required>
                                    </div>


                                </div>
                            </div>
                            {{-- <div class="row" style="margin-top: 20px;">
                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Product Title *</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" name="product" type="text" title="Product Title"
                                            placeholder="Product Title" required>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01111" class="form-label">Select Category *</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="category" class="select2 form-control" required>
                                            <option value=""> Select Category </option>
                                            @foreach ($category as $data)
                                                <option value="{{ $data->name }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                            </div> --}}
                            <div class="row" style="margin-top: 20px;">

                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label>District</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select onchange="fetch_subcategory_option()" name="district_id" id="district_id"
                                            class="form-control select2" required>
                                            <option value=""> --- Select District --- </option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div style="" class="col-md-6">
                                    {{-- <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Delivery Type</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="imp" class="imp form-control select2" required>
                                            <option value="Regular">Regular</option>
                                            <option value="Urgent">One Hour</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <label>Area</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="area" class="form-control select2" id="subcategory_option"
                                            required>
                                            <option value=""> Select Area </option>
                                        </select>
                                    </div>


                                </div>

                            </div>

                            <div class="row" style="margin-top: 20px;">

                                {{-- <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label>Area</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="area" class="form-control select2" id="subcategory_option"
                                            required>
                                            <option value=""> Select Area </option>
                                        </select>
                                    </div>


                                </div> --}}


                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Weight (Kg)*</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="select2 form-control" name="weight" name="weight" required>
                                            <option value=""> --- select weight --- </option>
                                            @foreach ($weights as $weight)
                                                <option value="{{ $weight->title }}">{{ $weight->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Selling Price(TK)</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input name="selling_price" class="form-control" id="selling_price"
                                            type="number" title="Selling Price" placeholder="Selling Price">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 20px;">

                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Collection(Tk)*</label>

                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" name="collection" type="number"
                                            title="Collection Amount" placeholder="Collection Amount" required>
                                    </div>
                                </div>

                                <div style="" class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Delivery Type</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="imp" class="imp form-control select2" required>
                                            <option value="Regular">Regular</option>
                                            <option value="Urgent">One Hour</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="row" style="margin-top: 20px;">

                                <div class="col-md-6">
                                    <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Order ID</label>
                                        </div>
                                        <div class="col-md-9">

                                            <input name="order_id" id="order_id" 
                                                class="form-control" type="text" title="Enter order ID"
                                                value="" >
                                        </div>



                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Pickup Date *</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input name="pickup_date" min="<?= date('Y-m-d') ?>" class="form-control"
                                            type="date" title="Select Pickup Date" value="{{ $today }}"
                                            required>
                                    </div>


                                </div> --}}
                                <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Remarks</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks">
                                    </div>

                                </div>
                                 
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                {{-- <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Pickup Time *</label>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="pickup_time" class="form-control" title="Select Pickup Time"
                                            required>
                                            @foreach ($pickup as $data)
                                                <option value="{{ $data->pick_up }}">{{ $data->pick_up }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-md-6">
                                    <div class="col-md-3">
                                        <label for="validationTooltip01" class="form-label">Remarks1</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="remarks" class="form-control" placeholder="Remarks">
                                    </div>

                                </div> --}}
                            </div>
                            <div class="row" style="margin-top: 20px">
                                <div class="col-md-0"></div>
                                <div class="col-md-6">
                                    <label for="validationTooltip01" class="form-label mt-4">Partial Delivery?</label>
                                    <input type="checkbox" class="form-check-input mt-4" name="isPartial"
                                        value="1">
                                    <label class="form-check-label" for="check1"> On </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">

                        </div>
                        <div class="row mt-2">



                            {{-- <div class="col-4">
                                <label for="validationTooltip01" class="form-label">Select Area *</label>
                                <select name="area" id="area" class="chosen-select form-control" title="Select Area"
                                    required>
                                    <option value=""> Select Area </option>
                                    @foreach ($area as $data)
                                        <option value="{{ $data->area }}">{{ $data->area }}</option>
                                    @endforeach
                                </select>
                            </div> --}}


                        </div>
                        <div class="row mt-2">

                        </div>
                        <div class="row mt-2">
                            {{-- <label for="validationTooltip01" class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" placeholder="Remarks"></textarea> --}}

                            <div class="col-4"></div>
                        </div>


                        <div class="row">
                            <div class="col-xs-8 col-md-4 col-sm-4">
                                <div class="mb-3">

                                </div>
                                <div class="mb-3 ">

                                </div>
                                <div class="mb-3">
                                    {{-- <label for="validationTooltip01" class="form-label">Customer Email
                                        (optional)</label>
                                    <input name="customer_email" type="email" class="form-control"
                                        placeholder="Customer Email"> --}}

                                </div>
                                <div class="mb-3">


                                </div>
                                <div class="mb-3">

                                </div>
                            </div>
                            <div class="col-xs-8 col-md-4 col-sm-4">
                                <div class="mb-3">

                                </div>

                                <div class="mb-3">

                                </div>

                                <div class="mb-3">

                                </div>
                                <div class="mb-3">

                                </div>
                                <div class="mb-3">

                                </div>
                            </div>
                            <div class="col-xs-8 col-md-4 col-sm-4">
                                <div class="mb-3">

                                </div>

                                <div class="mb-3">

                                </div>
                                <div class="mb-3">

                                </div>
                                <div class="mb-3">

                                </div>
                                <div class="mb-3">

                                </div>

                            </div>

                        </div>
                        <br>
                        <div style="text-align: center;" style="margin-top: -20px">

                            <button type="submit" class="button0 btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>



    </div>


    </div>







    <script>
        /* $('#order_place').on('submit', function(e) {

                if ($("#is_partial").is(":checked")) {
                    var is_partial_val = 1;

                } else {
                    var is_partial_val = 0;
                }

                console.log(is_partial_val);
                return ;

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
                        'shop': $("#shop").val(),
                        'area': $("#area").val(),
                        'pickup_date': $("#pickup_date").val(),
                        'pickup_time': $("#pickup_time").val(),
                        'remarks': $("#remarks").val(),
                        'category': $("#category").val(),
                        'product': $("#pro_title").val(),
                        'weight': $("#weight").val(),
                        'collection': $("#collection").val(),
                        'imp': $(".imp").val(),
                        'is_partial': is_partial_val,

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

            */
    </script>

    <script>
        $('#merchant').change(function() {

            $('#shop').empty();
            $('#shop').append($('<option>', {
                value: '',
                text: 'Select Shop'
            }));

            var user_id = $('#merchant :selected').val();

            $.ajax({
                url: "{{ route('ajaxdata.shop') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id
                },
                cache: false,
                dataType: 'json',
                success: function(dataResult) {

                    var resultData = dataResult.data;

                    $.each(resultData, function(index, row) {

                        $('#shop').append($('<option>', {
                            value: row.shop_name,
                            text: row.shop_name
                        }));

                    })


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
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('fetch.subcategory.value') }}",
                data: {
                    id: id,
                },
                success: function(data) {

                    $('#subcategory_option').empty();
                    $.each(data.options, function(index, option) {

                        $('#subcategory_option').append('<option value="' + option.area + '">' +
                            option.area + '</option>');
                    });


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
