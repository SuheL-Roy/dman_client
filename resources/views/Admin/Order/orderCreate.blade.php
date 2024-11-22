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
</style>
@section('content')
    <!-- CSS only -->
    <div class="container-fluid">
        @canany(['activeEmployee', 'activeMerchant'])
        @endcanany
        <div class="container-fluid p-4">
            <div class="card">
                <div class="acrd-header">
                    <h1 class="mt-3 text-center">Add Parcel</h1>
                    <hr>
                </div>

                <div class="card-body">
                    <div class="container-fluid">
                        <form class="payment-form" action="{{ route('order.store') }}" method="POST">
                            @csrf
                            <input name="tracking_id" type="hidden" id="tracking_id" value="{{ $track }}"
                                class="form-control" style="border:hidden;">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <label for="formGroupExampleInput" class="form-label">Customer Name*</label><br>
                                        </div>
                                        <div class="col-md-9">
                                            <input name="customer_name" id="name" type="text" class="form-control"
                                                required placeholder="Customer Name" required>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <label for="validationTooltip01" class="form-label">Contact Number*</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input name="customer_phone" placeholder="Contact number" id="phone"
                                                type="text" class="form-control " value="" required
                                                autocomplete="phone" placeholder="" maxlength="11" minlength="11">
                                        </div>


                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <label for="validationTooltip01" class="form-label">Alternative Number</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input name="other_number" placeholder="Alternative number" id="other_number"
                                                type="text" class="form-control " value=""
                                                autocomplete="other_number" placeholder="" maxlength="11" minlength="11">
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <label for="validationTooltip01" class="form-label">Address*</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" name="customer_address" id="address"
                                                class="form-control" placeholder="Address" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    {{-- <div class="col-md-6">
                                        <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Product Title</label>
                                        </div>
                                        <div class="col-md-9">

                                            <input name="product" class="form-control" id="pro_title" type="text"
                                                title="Product Title" placeholder="Product Title" required>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Order ID</label>
                                        </div>
                                        <div class="col-md-9">

                                            <input name="order_id" id="order_id" 
                                                class="form-control" type="text" title="Enter order ID"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <label for="validationTooltip01" class="form-label">Order Chategory*</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="category" id="category" class="form-control select2"
                                                title="Select Category" required>
                                                <option value=""> Select Category </option>
                                                @foreach ($category as $data)
                                                    <option value="{{ $data->name }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                                <div class="error">{{ $errors->first('category') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                   

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <label>District</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select onchange="fetch_subcategory_option()" name="district_id"
                                                id="district_id" class="js-example-basic-single form-control select2"
                                                required>
                                                <option value=""> --- Select District --- </option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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

                                <div class="row" style="margin-top: 20px">
                                   

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <label for="validationTooltip01" class="form-label">Weight(KG)</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control select2" name="weight" id="weight" required>
                                                <option value=""> --- select weight --- </option>
                                                @foreach ($weights as $weight)
                                                    <option value="{{ $weight->title }}">{{ $weight->title }}</option>
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
                                <div class="row" style="margin-top: 20px">
                                 
                                    <div class="col-md-6">
                                        <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Collection(TK)</label>
                                        </div>
                                        <div class="col-md-9">

                                            <input name="collection" class="form-control" id="collection" type="number"
                                                title="Collection Amount" placeholder="collection amount" required>
                                        </div>
                                    </div>
                                     <div  class="col-md-6">
                                        <div class="col-md-3">
                                            <label for="validationTooltip01" class="form-label">Delivery Type</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="imp" class="imp form-control" required>
                                                <option value="Regular">Regular</option>
                                                <option value="Urgent">Express</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 20px">
                                  
                                    <div class="col-md-6">

                                        <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Reamrks</label>
                                        </div>
                                        <div class="col-md-9">

                                            <input type="text" name="remarks" id="remarks" class="form-control"
                                                placeholder="Remarks" class="form-control">
                                        </div>
                                       
                                    </div>
                                </div>
                                   <div class="row" style="margin-top: 20px">
                                    {{-- <div class="col-md-6">
                                        <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Pickup Date*</label>
                                        </div>
                                        <div class="col-md-9">

                                            <input name="pickup_date" id="pickup_date" min="<?= date('Y-m-d') ?>"
                                                class="form-control" type="date" title="Select Pickup Date"
                                                value="{{ $today }}" required>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-6">
                                        <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Pickup Time*</label>
                                        </div>
                                        <div class="col-md-9">

                                            <select name="pickup_time" id="pickup_time" class="form-control"
                                                title="Select Pickup Time" required>
                                                @foreach ($pickup as $data)
                                                    <option value="{{ $data->pick_up }}">{{ $data->pick_up }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row" style="margin-top: 20px">
                                    <div class="col-md-6">
                                        <div class="col-md-3">

                                            <label for="validationTooltip01" class="form-label">Partial Delivery?</label>
                                         </div>
                                         <div class="col-md-9">
 
                                              <input name="is_partial" style="margin-left: 22px;" class=" form-check-input"
                                                 type="checkbox" id="is_partial" name="is_partial" value="1">
                                             <label class="form-check-label" for="check1">
                                                 on
                                             </label>
                                         </div>
                                    </div>
                                  
                                </div>

                            </div>

                            <div class="row mt-2">



                            </div>

                            <div class="row mt-2">





                            </div>

                            <div class="row mt-2">



                            </div>

                            <div class="row mt-2">
                                <div class="col-4"></div>

                                <div class="col-4">

                                </div>
                            </div>
                            <hr>
                            <div style="text-align: center;" class="mb-3">
                                <button type="button" class="submit_margin btn btn-warning mr-4">
                                    <i class="fa fa-close"></i>
                                    Clear</button>
                                <button type="submit" name="sumbit" value="1" class=" btn btn-success"> <i
                                        class="fa fa-check"></i>
                                    Submit</button>

                                <button type="submit" name="preview" value="2"
                                    class=" btn btn-success">Preview</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


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