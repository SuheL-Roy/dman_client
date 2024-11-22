@extends('Master.main')
@section('title')
    Order Confirmation
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h4 class="mt-3">Order Confirmation</h4>
            </div>
            <div class="col">
                @if (session('message'))
                    <div class="text-center alert alert-dismissible alert-success"
                        style="padding-top:5px; padding-bottom:5px; 
            margin-top:0px; margin-bottom:0px;">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <hr>
        <div class="container ">


            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="formGroupExampleInput" class="form-label">Customer Name*</label><br>
                    </div>
                    <div class="col-md-9">
                        <input name="customer_name" id="name" value="{{ $order->customer_name }}" type="text"
                            class="form-control" placeholder="Customer Name" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Contact Number*</label>
                    </div>
                    <div class="col-md-9">
                        <input name="customer_phone" placeholder="Contact number" id="phone" type="text"
                            class="form-control" value="{{ $order->customer_phone }}" readonly>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Alternative Number</label>
                    </div>
                    <div class="col-md-9">
                        <input name="other_number" placeholder="Alternative number" id="other_number" type="text"
                            class="form-control " value="{{ $order->other_number ?? '' }}" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Address*</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="customer_address" value="{{ $order->customer_address }}" id="address"
                            class="form-control" placeholder="Address" readonly>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="col-md-3">

                        <label for="validationTooltip01" class="form-label">Product Title</label>
                    </div>
                    <div class="col-md-9">

                        <input name="product" value="{{ $order->product }}" class="form-control" id="pro_title"
                            type="text" title="Product Title" placeholder="Product Title" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Select Chategory*</label>
                    </div>
                    <div class="col-md-9">
                        <select name="category" id="category" class="form-control select2" title="Select Category"
                            readonly>
                            <option value=""> Select Category </option>
                            @foreach ($category as $data)
                                <option value="{{ $data->name }}" {{ $order->category == $data->name ? 'selected' : '' }}>
                                    {{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Delivery Type {{ $order->type }} </label>
                    </div>
                    <div class="col-md-9">
                        <select name="imp" class="imp form-control" readonly>
                            <option value="Regular"> {{ $order->type }} </option>
                        </select>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="col-md-3">
                        <label>District</label>
                    </div>
                    <div class="col-md-9">
                        <select onchange="fetch_subcategory_option()" name="district_id" id="district_id"
                            class="js-example-basic-single form-control select2" readonly>
                            @foreach ($area as $data)
                                <option value="{{ $data->area }}" {{ $order->area == $data->area ? 'selected' : '' }}>
                                    {{ $data->area }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>




                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label"> Pickup Date * </label>
                    </div>
                    <div class="col-md-9">
                        <input id="pickup_date" class="form-control" type="date" title="Select Pickup Date"
                            name="pickup_date" value="{{ $order->pickup_date }}" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-md-3">
                        <label>Pickup Time *</label>
                    </div>
                    <div class="col-md-9">
                        <select id="pickup_time" class="form-control" name="pickup_time" title="Select Pickup Time"
                            readonly>
                            @foreach ($pickup as $data)
                                <option value="{{ $data->pick_up }}"
                                    {{ $order->pick_up == $data->pick_up ? 'selected' : '' }}>
                                    {{ $data->pick_up }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-md-4">

                    <div class="col-md-3">
                        <label>Status</label>
                    </div>
                    <div class="form-group col-lg-9">
                        <input type="text" required class="form-control" name="status" value="{{ $order->status }}"
                            readonly>
                    </div>
                </div>



                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Collection</label>
                    </div>
                    <div class="col-md-9">

                        <input name="collection" class="form-control" value="{{ $order->collection }}" id="collection"
                            type="number" title="Collection Amount" placeholder="collection amount" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Delivery</label>
                    </div>
                    <div class="col-md-9">

                        <input name="delivery" class="form-control" value="{{ $order->delivery }}" id="delivery"
                            type="number" title="Collection Amount" placeholder="delivery amount" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">Risk Fee</label>
                    </div>
                    <div class="col-md-9">
                        <input name="insurance" class="form-control" value="{{ $order->insurance }}" id="insurance"
                            type="number" title="Collection Amount" placeholder="insurance amount" readonly>
                    </div>
                </div>

                <div class="col-md-4" style="margin-top: 10px">
                    <div class="col-md-3">
                        <label for="validationTooltip01" class="form-label">COD</label>
                    </div>
                    <div class="col-md-9">
                        <input name="cod" class="form-control" value="{{ $order->cod }}" id="cod"
                            type="number" title="Collection Amount" placeholder="cod amount" readonly>
                    </div>
                </div>

            </div>
            <div style="text-align: center;" class="mb-3">
                <a class="btn btn-info button0 mr-4" href="{{ route('order.create') }}">Back</a>
            </div>
        </div>
    </div>

    <script>
        $('#BCK').on('click', function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('order.edit') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    location.href = "{{ route('order.edit') }}";
                }
            });
        });
    </script>

    <script>
        $('#order_confirm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('order.confirm') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tracking_id': $("#track").val(),
                    'collection': $("#collection").val(),
                    'delivery': $("#delivery").val(),
                    'insurance': $("#insurance").val(),
                    'cod': $("#cod").val(),
                    'merchant_pay': $("#m_pay").val(),
                },
                success: function() {
                    location.href = "{{ route('order.lists') }}";
                },
                error: function(error) {
                    console.log(error);
                    alert('Order Not Confirmed');
                }
            });
        });
    </script>
@endsection
