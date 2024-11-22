@extends('Master.main')
@section('title')
    Edit Order
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-12">Edit Order</h1>
                                <div class="container col-lg-4">
                                    @if (session('success'))
                                        <div class="alert alert-dismissible alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('success') }}</strong>
                                        </div>
                                    @elseif(session('message'))
                                        <div class="alert alert-dismissible alert-info">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @elseif(session('danger'))
                                        <div class="alert alert-dismissible alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('danger') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <form name="payment-form"
                                    action="{{ route('order.update', ['tracking_id' => $order->tracking_id]) }}"
                                    method="POST">
                                    @csrf

                                    <input type="hidden" name="fromdate" value="{{ $fromdate }}">
                                    <input type="hidden" name="todate" value="{{ $todate }}">
                                    <div class="row">

                                        <div class="col-lg-5">
                                            <label class="col-lg-4">Tracking ID. *</label>
                                            <div class="form-group col-lg-8">
                                                <input name="tracking_id" value="{{ $order->tracking_id }}"
                                                    class="form-control" readonly style="border:hidden;">
                                            </div>
                                            <label class="col-lg-4">Customer Name *</label>
                                            <div class="form-group col-lg-8">
                                                <input type="text" value="{{ $order->customer_name }}"
                                                    class="form-control" name="customer_name" required
                                                    placeholder="Customer Name">
                                            </div>
                                            <label class="col-lg-4">Customer Email</label>
                                            <div class="form-group col-lg-8">
                                                <input type="text" value="{{ $order->customer_email }}"
                                                    class="form-control" name="customer_email" placeholder="Customer Email">
                                            </div>

                                            <label class="col-lg-4">Customer Phone *</label>
                                            <div class="form-group col-lg-8">
                                                <input name="customer_phone" type="number" class="form-control"
                                                    value="{{ $order->customer_phone }}" required
                                                    placeholder="Customer Phone">
                                            </div>
                                            <label class="col-lg-4">Address *</label>
                                            <div class="form-group col-lg-8">
                                                <textarea name="customer_address" class="form-control" required placeholder="Address">{{ $order->customer_address }}</textarea>
                                            </div>
                                            <label class="col-lg-4">Selling Price(TK)</label>
                                            <div class="form-group col-lg-8">
                                                <input class="form-control" id="selling_price" type="text"
                                                    name="selling_price" title="Selling Price" placeholder="Selling Price"
                                                    required value="{{ $order->selling_price }}">
                                            </div>

                                            <label class="col-lg-4">Collection Amount *</label>
                                            <div class="form-group col-lg-8">
                                                <input class="form-control" id="collection" type="text" name="collection"
                                                    title="Collection Amount" placeholder="Collection Amount" required
                                                    value="{{ $order->collection }}">
                                            </div>
                                            <label class="col-lg-4">Collect Amount *</label>
                                            <div class="form-group col-lg-8">
                                                <input class="form-control" id="collect" type="text" name="collect"
                                                    title="Collect Amount" placeholder="Collect Amount" required
                                                    value="{{ $order_confirm->collect }}">
                                            </div>

                                            @cannot('activeMerchant')
                                                <label class="col-lg-4"> Security Code</label>
                                                <div class="form-group col-lg-8">
                                                    <input class="form-control" id="security_code" type="text"
                                                        name="security_code" title="Security Code" placeholder="Security Code"
                                                        value="{{ $order->security_code }}">
                                                </div>
                                            @endcannot

                                            <label class="col-lg-4"> Return Code</label>
                                            <div class="form-group col-lg-8">
                                                <input class="form-control" id="return_code" type="text"
                                                    name="return_code" title="Return Code" placeholder="Return Code"
                                                    value="{{ $order->return_code }}">
                                            </div>
                                            <label class="col-lg-4">Partial Delivery?</label>
                                            <div class="form-group col-lg-8">
                                                {{-- <input class="form-control" type="number" title="Weight"
                                                    placeholder="Weight" name="weight" value="{{ $order->weight }}"
                                                    required> --}}


                                                <input type="checkbox" class="form-check-input" id="is_partial"
                                                    name="is_partial" {{ $order->isPartial == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="check1"> On </label>
                                            </div>



                                        </div>

                                        <div class="col-lg-5">

                                            <label class="col-lg-4">Order ID</label>
                                            <div class="form-group col-lg-8">
                                                <input name="order_id" type="text" class="form-control"
                                                    value="{{ $order->order_id }}" placeholder="Order ID">

                                            </div>

                                            <label class="col-lg-4">District*</label>
                                            <div class="form-group col-lg-8">
                                                <select onchange="fetch_subcategory_option()" name="district_id"
                                                    id="district_id" class="form-control select2" required>
                                                    <option value=""> --- Select District --- </option>
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}"
                                                            {{ $order->district == $district->name ? 'selected' : '' }}>
                                                            {{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <label class="col-lg-4">Destination *</label>
                                            <div class="form-group col-lg-8">
                                                <select id="subcategory_option" name="area"
                                                    class="form-control select2" title="Select Area" required>
                                                    <option value=""> Select Area </option>
                                                    @foreach ($area_data as $data)
                                                        <option value="{{ $data->area }}"
                                                            {{ $order->area == $data->area ? 'selected' : '' }}>
                                                            {{ $data->area }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <label class="col-lg-4">Select Category *</label>
                                            <div class="form-group col-lg-8">
                                                <select id="category" class="form-control" name="category"
                                                    title="Select Category">
                                                    <option value=""> Select Category </option>
                                                    @foreach ($category as $data)
                                                        <option value="{{ $data->name }}"
                                                            {{ $order->category == $data->name ? 'selected' : '' }}>
                                                            {{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <label class="col-lg-4">Product Title *</label>
                                            <div class="form-group col-lg-8">
                                                <input class="form-control" id="pro_title" type="text"
                                                    title="Product Title" name="product" value="{{ $order->product }}"
                                                    placeholder="Product Title">
                                            </div>



                                            <label class="col-lg-4">Weight *</label>
                                            <div class="form-group col-lg-8">
                                                <select class="chosen-select bravo" name="weight" id="weight"
                                                    required>
                                                    <option value=""> --- select weight --- </option>
                                                    @foreach ($weights as $weight)
                                                        <option value="{{ $weight->title }}"
                                                            {{ $order->weight == $weight->title ? 'selected' : '' }}>
                                                            {{ $weight->title }}</option>
                                                    @endforeach
                                                </select>


                                            </div>


                                            <label class="col-lg-4">Delivery Type</label>

                                            <div class="form-group col-lg-8">
                                                <select name="imp" class="imp form-control" required>
                                                    @if ($order->type == 'Urgent')
                                                        <option value="Urgent">Express</option>
                                                        <option value="Regular">Regular</option>
                                                    @else
                                                        <option value="Regular">Regular</option>
                                                        <option value="Urgent">Express</option>
                                                    @endif
                                                </select>
                                            </div>

                                            <label class="col-lg-4">Pickup Date *</label>
                                            <div class="form-group col-lg-8">
                                                <input id="pickup_date" class="form-control" type="date"
                                                    title="Select Pickup Date" name="pickup_date"
                                                    value="{{ $order->pickup_date }}">
                                            </div>
                                            <label class="col-lg-4">Pickup Time *</label>
                                            <div class="form-group col-lg-8">
                                                <select id="pickup_time" class="form-control" name="pickup_time"
                                                    title="Select Pickup Time">
                                                    @foreach ($pickup as $data)
                                                        <option value="{{ $data->pick_up }}"
                                                            {{ $order->pick_up == $data->pick_up ? 'selected' : '' }}>
                                                            {{ $data->pick_up }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="col-lg-4">Remarks</label>
                                            <div class="form-group col-lg-8">
                                                <textarea class="form-control" name="remarks" placeholder="Remarks">{{ $order->remarks }}</textarea>

                                            </div>


                                        </div>

                                    </div>
                                    <hr>
                                    <div class="text-center credit-card-custom">
                                        <button type="submit" class="btn btn-lg btn-success">
                                            Order Update <i class="fa fa-check-circle"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('change', '#weight', function() {

            var selectedValue = $(this).val();


            $.ajax({
                type: "GET",
                url: "{{ route('order.weight_wise_charge') }}",
                data: {
                    selectedValue: selectedValue
                },
                success: function(data) {
                    console.log(data);
                    // Handle the response data as needed
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

    <script>
        function fetch_subcategory_option() {
            var id = $('#district_id').val();


            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('fetch.subcategory.value') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                },
                success: function(data) {

                    $('#subcategory_option').empty();
                    $('#subcategory_option').append('<option value="' + '' + '">' +
                        'Select Area' + '</option>');
                    $.each(data.options, function(index, option) {

                        $('#subcategory_option').append('<option value="' + option.area + '">' +
                            option.area + '</option>');
                    });


                },
            })









        };
    </script>
@endsection
