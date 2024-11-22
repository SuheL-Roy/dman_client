@extends('Master.main')
@section('title')
    Order
@endsection
@section('content')

<div class="product-cart-area mg-t-15">
    <div class="container-fluid">
        <div class="row">
            <div class="product-cart-inner">
                <div id="example-basic">
                    <h3>Place Order</h3>
                    <section>
                        <div class="product-list-cart">
                            <form class="payment-form" id="order_stor">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label class="col-lg-4">Tracking ID *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="tracking_id" value="{{ $track }}" 
                                                class="form-control" readonly style="width:100%;">
                                        </div>
                                        <label class="col-lg-4">Merchant Order ID *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="order_id" type="text" style="width:100%;"
                                                class="form-control" required
                                                placeholder="Merchant Order ID">
                                        </div>
                                        <label class="col-lg-4">Customer Name *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="name" type="text" style="width:100%;"
                                                class="form-control" required
                                                placeholder="Customer Name">
                                        </div>
                                        <label class="col-lg-4">Customer Email</label>
                                        <div class="form-group col-lg-8">
                                            <input id="email" type="email" 
                                                class="form-control" style="width:100%;"
                                                placeholder="Customer Email">
                                        </div>
                                        <label class="col-lg-4">Customer Phone *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="phone" type="number" style="width:100%;"
                                                class="form-control" required
                                                placeholder="Customer Phone">
                                        </div>
                                        <label class="col-lg-4">Address *</label>
                                        <div class="form-group col-lg-8">
                                            <textarea id="address" class="form-control"
                                                placeholder="Address" required
                                                style="height:100px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="col-lg-4">Select Shop *</label>
                                        <div class="form-group col-lg-8">
                                            <select id="shop" class="form-control" 
                                                title="Select Shop" required>
                                                @foreach ($shop as $data)
                                                <option value="{{ $data->id }}">{{ $data->shop_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-lg-4">Select Destination *</label>
                                        {{--  <div class="form-group col-lg-8">
                                            <select id="area" class="select2_demo_3 form-control" 
                                                    title=" Select Area " required>
                                                <option value=""> Select Destination </option>
                                                @foreach ($area as $data)
                                                <option value="{{ $data->id }}">{{ $data->area }}</option>
                                                @endforeach
                                            </select>
                                        </div>  --}}
                                        <div class="form-group col-lg-8">
                                            <select class="chosen -select select2 _demo_3 form-control"
                                                id="area" title="Destination">
                                                <option value="">Select Destination</option>
                                                @foreach ($area as $data)
                                                <option value="{{ $data->id }}">{{ $data->area }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label class="col-lg-4">Pickup Date *</label>
                                        <div class="form-group col-lg-8">
                                            <input id="pickup_date" type="date" style="width:100%;"
                                                class="form-control" title="Select Pickup Date"
                                                required value="{{ $today }}">
                                        </div>
                                        <label class="col-lg-4">Pickup Time *</label>
                                        <div class="form-group col-lg-8">
                                            <select id="pickup_time" class="form-control" 
                                                title="Select Pickup Time" required>
                                                <option value="1"> 10 am -12 am </option>
                                                <option value="2"> 12 am -2 am </option>
                                                <option value="3"> 2 am - 4 am </option>
                                                <option value="4"> 4 am - 6 am </option>
                                            </select>
                                        </div>
                                        <label class="col-lg-4">Remarks </label>
                                        <div class="form-group col-lg-8">
                                            <textarea id="remarks" class="form-control"
                                                placeholder="Remarks" style="height:100px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                {{--  <div class="text-center">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                                        Submit 
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </button>
                                </div>  --}}
                            </form>
                        </div>
                    </section>
                    <h3>Order Confirmation</h3>
                    <section>
                        <div class="payment-details">
                            <div class="row">
                                <div class="col-lg-4 row">
                                    <div class="col-lg-6 text-left">
                                        <h5>Tracking ID.</h5>
                                        <h5>Merchant Order ID.</h5>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        <h5>: HD10200413</h5>
                                        <h5>: 00900901</h5>
                                    </div>
                                </div>
                                <div class="col-lg-5 row">
                                    <div class="col-lg-5 text-left">
                                        <h5>Customer Name</h5>
                                        {{-- <h5>Customer E-mail</h5> --}}
                                        <h5>Customer Mobile</h5>
                                    </div>
                                    <div class="col-lg-7 text-left">
                                        <h5>: Mr. Pull Drack</h5>
                                        {{-- <h5>: admin@gmail.com</h5> --}}
                                        <h5>: +88 01710000000</h5>
                                    </div>
                                </div>
                                <div class="col-lg-3 row">
                                    <div class="col-lg-6 text-left">
                                        {{-- <h5>Pickup Address</h5> --}}
                                        <h5>Pickup Date</h5>
                                        <h5>Pickup Time</h5>
                                    </div>
                                    <div class="col-lg-6 text-left">
                                        {{-- <h5>: Cantonment Dhaka-1209.</h5> --}}
                                        <h5>: 12/09/2020</h5>
                                        <h5>: 12:34pm</h5>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    {{-- <div class="product-status-wrap">
                                    {{-- style="overflow: scroll; height: 300px;"> --}}
                                    <div class="sparkline8-graph">
                                        <div class="static-table-list">
                                            <table class="table">
                                                <tr>
                                                    <th>SL.</th>
                                                    <th>Product Title</th>
                                                    <th>Category</th>
                                                    <th>Quantity</th>
                                                    <th>Weight</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                </tr>
                                                <?php $s = 1; ?>
                                                <tr>
                                                    <td>{{ $s++ }}.</td>
                                                    <td>Jewelery Title 1</td>
                                                    <td>
                                                        {{-- <button class="pd-setting">Active</button> --}}
                                                    </td>
                                                    <td>50</td>
                                                    <td>15</td>
                                                    <td>750</td>
                                                    <td>1750</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="sparkline8-graph">
                                        <div class="static-table-list">
                                            <table class="table">
                                                <tbody style="font-weight:bold;">
                                                    <tr>
                                                        <td class="text-left">Total Quantity</td>
                                                        <td class="text-right">5</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Total Weight</td>
                                                        <td class="text-right">2 Kg</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Total Amount</td>
                                                        <td class="text-right">Tk. 1500</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Discount Amount</td>
                                                        <td class="text-right">Tk. 500</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Collection Amount</td>
                                                        <td class="text-right">Tk. 1000</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Delivery Charge</td>
                                                        <td class="text-right">Tk. 100</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">COD Charge</td>
                                                        <td class="text-right">Tk. 0</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">Machant Pay</td>
                                                        <td class="text-right">Tk. 900</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-block btn-success">Confirmation</button>
                        </div>
                    </section>
                    {{--  <h3>Confirmation</h3>
                    <section>
                        <div class="product-confarmation">
                            <h2>Congratulations! Your Order is accepted.</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled
                                it to make a type specimen book.</p>
                            <button class="btn btn-primary m-y">Track Order</button>
                        </div>
                    </section>  --}}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#order_stor').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ route('order.store') }}",
            data: {
                '_token'            : $('input[name=_token]').val(),
                'tracking_id'       : $("#tracking_id").val(),
                'order_id'          : $("#order_id").val(),
                'customer_name'     : $("#name").val(),
                'customer_email'    : $("#email").val(),
                'customer_phone'    : $("#phone").val(),
                'customer_address'  : $("#address").val(),
                'shop'              : $("#shop").val(),
                'area'              : $("#area").val(),
                'pickup_date'       : $("#pickup_date").val(),
                'pickup_time'       : $("#pickup_time").val(),
                'remarks'           : $("#remarks").val(),
            },
            success: function () {
                alert('Order Placed');
            },
            error: function (error) {
                console.log(error);
                alert('Order Not Placed');
            }
        });
    });
</script>

@endsection
