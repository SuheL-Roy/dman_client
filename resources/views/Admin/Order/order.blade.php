@extends('Master.main')
@section('title')
    Order
@endsection
@section('content')

<div class="single-pro-review-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-payment-inner-st">
                    <ul id="myTab4" class="tab-review-design">
                        <li class="active"><a href="#order">Place Order</a></li>
                        {{--  <li><a href="#details">Product Details</a></li>  --}}
                        <li><a href="#confirm">Order Confirmation</a></li>
                        {{--  <li><a href="#netbanking">Order Confirmation</a></li>
                        <li><a href="#cod">Order Confirmation</a></li>  --}}
                        <li>
                            @if(session('message'))
                                <div class="text-center alert alert-dismissible alert-success"
                                    style="padding-top:0px; padding-bottom:0px;">
                                    <button type="button" class="close" data-dismiss="alert">×</span>
                                    </button>
                                    <strong>{{ session('message') }}</strong>
                                </div>      
                            @endif
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content custom-product-edit">
                        
                        <div class="product-tab-list tab-pane fade active in" id="order">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div class="demo-container">
                                            <div class="card-wrapper"></div>
                                            <form class="payment-form" id="order_place" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label class="col-lg-4">Tracking ID. *</label>
                                                        <div class="form-group col-lg-8">
                                                            <input id="tracking_id" value="{{ $track }}" 
                                                                class="form-control" readonly 
                                                                style="border:hidden;">
                                                        </div>
                                                        <label class="col-lg-4">Merchant Order ID. *</label>
                                                        <div class="form-group col-lg-8">
                                                            <input id="order_id" type="text" 
                                                                class="form-control" required
                                                                placeholder="Merchant Order ID.">
                                                        </div>
                                                        <label class="col-lg-4">Select Shop *</label>
                                                        <div class="form-group col-lg-8">
                                                            <select id="shop" class="form-control" 
                                                                title="Select Shop" required>
                                                                @foreach ($shop as $data)
                                                                <option value="{{ $data->id }}">{{ $data->shop_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <label class="col-lg-4">Customer Name *</label>
                                                        <div class="form-group col-lg-8">
                                                            <input id="name" type="text" 
                                                                class="form-control" required
                                                                placeholder="Customer Name">
                                                        </div>
                                                        <label class="col-lg-4">Customer Email</label>
                                                        <div class="form-group col-lg-8">
                                                            <input id="email" type="email" 
                                                                class="form-control"
                                                                placeholder="Customer Email">
                                                        </div>
                                                        <label class="col-lg-4">Customer Phone *</label>
                                                        <div class="form-group col-lg-8">
                                                            <input id="phone" type="number" 
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
                                                        <label class="col-lg-4">Select Area *</label>
                                                        <div class="form-group col-lg-8">
                                                            <select id="area" class="chosen-select" 
                                                                    title="Select Area" required>
                                                                {{--  <option value=""> Select Area </option>  --}}
                                                                @foreach ($area as $data)
                                                                <option value="{{ $data->id }}">{{ $data->area }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <label class="col-lg-4">Select Category *</label>
                                                        <div class="form-group col-lg-8">
                                                            <select id="category" class="form-control" 
                                                                    title="Select Category" required>
                                                                <option value=""> Select Category </option>
                                                                @foreach ($category as $data)
                                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <label class="col-lg-4">Product Title *</label>
                                                        <div class="form-group col-lg-8">
                                                            <input class="form-control" id="pro_title" 
                                                                type="text" title="Product Title"
                                                                placeholder="Product Title" required>
                                                        </div>
                                                        <label class="col-lg-4">Weight *</label>
                                                        <div class="form-group col-lg-8">
                                                            <select id="weight" class="form-control" 
                                                                title="Select Weight" required>
                                                                <option value="">Select Weight</option>
                                                                <option value="500 gm">500 gm</option>
                                                                <option value="1 kg">1 kg</option>
                                                                <option value="2 kg">2 kg</option>
                                                                <option value="3 kg">3 kg</option>
                                                            </select>
                                                        </div>
                                                        <label class="col-lg-4">Collection Amount *</label>
                                                        <div class="form-group col-lg-8">
                                                            <input class="form-control" id="collection" 
                                                                type="text" title="Collection Amount"
                                                                placeholder="Collection Amount" required>
                                                        </div>
                                                        <label class="col-lg-4">Pickup Date *</label>
                                                        <div class="form-group col-lg-8">
                                                            <input id="pickup_date" class="form-control"
                                                                type="date" title="Select Pickup Date"
                                                                value="{{ $today }}" required>
                                                        </div>
                                                        <label class="col-lg-4">Pickup Time *</label>
                                                        <div class="form-group col-lg-8">
                                                            <select id="pickup_time" class="form-control" 
                                                                title="Select Pickup Time" required>
                                                                @foreach ($pickup as $data)
                                                                <option value="{{ $data->pick_up }}">{{ $data->pick_up }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        <label class="col-lg-4">Remarks </label>
                                                        <div class="form-group col-lg-8">
                                                            <textarea id="remarks" class="form-control"
                                                                placeholder="Remarks" style="height: ;"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                            Submit 
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <div class="text-center credit-card-custom">
                                                    {{--  <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                        Submit 
                                                        <i class="fa fa-arrow-circle-right"></i>
                                                    </button>  --}}
                                                    {{--  <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                        Submit & Go Next for Product Details
                                                        <i class="fa fa-arrow-circle-right"></i>
                                                    </button>  --}}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-tab-list tab-pane fade" id="details">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="review-content-section">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="form-group">
                                                <label>Tracking ID.</label>
                                                <input id="tracking_id" readonly
                                                    value="{{ Session::get('track') }}" required
                                                    style="border:hidden;" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label>Merchant Order ID.</label>
                                                <input id="orderId" readonly
                                                    value="{{ Session::get('order') }}" required 
                                                    class="form-control" style="border:hidden;">
                                            </div>
                                            <div class="form-group">
                                                <label>Products</label>
                                                {{--  <select class="select2_demo_3 productId form-control" 
                                                    data-live-search="true" data-style="btn-info"
                                                    style="width:100%;" data-placeholder="Select Product">
                                                    <option value="">Select Product</option>
                                                    @foreach ($product as $data)
                                                    <option value="{{ $data->id }}">{{ $data->title }}</option>
                                                    @endforeach
                                                </select>  --}}
                                                <select class="chosen -select productId form-control"> 
                                                    <option value="">Choose a Product ...</option>
                                                    @foreach ($product as $data)
                                                    <option value="{{ $data->id }}">{{ $data->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                            <div class="sparkline8-graph">
                                                <div class="static-table-list">
                                                    {{-- style="overflow: scroll; height: 400px;"> --}}
                                                    <h4 class="text-center">Products Details Table</h4>
                                                    <table class="table">
                                                        <tr>
                                                            <th>SL.</th>
                                                            <th>Product Title</th>
                                                            <th>Category</th>
                                                            <th class="text-center">Qty</th>
                                                            <th class="text-center">Weight</th>
                                                            <th class="text-right">Price (Tk)</th>
                                                            <th class="text-right">Total (Tk)</th>
                                                            <th data-field="action">Action</th>
                                                        </tr>
                                                        <?php $s = 1; ?>
                                                        <tr>
                                                            <td>{{ $s++ }}.</td>
                                                            <td style="width:20%">
                                                                <input class="title form-control" readonly
                                                                    id="p_title" style="border:hidden;">
                                                            </td>
                                                            <td style="width:20%">
                                                                <input class="category form-control" readonly 
                                                                    id="p_category" style="border:hidden;">
                                                            </td>
                                                            <td>                                                                
                                                                <input class="quantity form-control text-center" 
                                                                    id="p_quantity" style="border:hidden;">
                                                            </td>
                                                            <td>                                                                
                                                                <input class="weight form-control text-center" 
                                                                    id="p_weight" style="border:hidden;" readonly>
                                                            </td>
                                                            <td class="text-right">                                                               
                                                                <input class="unit_price form-control text-right" 
                                                                    id="p_price" style="border:hidden;" readonly>
                                                            </td class="text-right">
                                                            <td>                                                              
                                                                <input class="total form-control" readonly
                                                                    id="p_total" style="border:hidden;">
                                                            </td>
                                                            <td class="text-right">
                                                                <button title="Trash" type="button" 
                                                                    class="btn btn-warning btn-xs">
                                                                    <i class="fa fa-trash-o"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3" class="text-right">Total : </td>
                                                                <td>5</td>
                                                                <td>1.5 Kg</td>
                                                                <td></td>
                                                                <td>1500</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6" class="text-right">Discount : </td>
                                                                <td>
                                                                    <input class="form-control" value="0" 
                                                                        style="width:100px;" type="number">
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="6" class="text-right">Total Amount : </td>
                                                                <td>1500</td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Submit
                                    {{--  <i class="fa fa-arrow-circle-right"></i>  --}}
                                </button>
                                {{--  <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Submit & Go Next for Order Confirmation
                                    <i class="fa fa-arrow-circle-right"></i>
                                </button>  --}}
                            </div>
                        </div>

                        <div class="product-tab-list tab-pane fade" id="confirm">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="container row">
                                    <div class="col-lg-4 row">
                                        <div class="col-lg-6 text-left" style="padding:0px;">
                                            <h5>Tracking ID.</h5>
                                            <h5>Merchant Order ID.</h5>
                                        </div>
                                        <div class="col-lg-6 text-left" style="padding:0px;">
                                            <div>: <input id="t_id" style="border:hidden; width:140px;"
                                                value="{{ Session::get('track') }}" readonly>
                                            </div>
                                            <div>: <input id="o_id" style="border:hidden; width:140px;"
                                                value="{{ Session::get('order') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 row">
                                        <div class="col-lg-5 text-left" style="padding:0px;">
                                            <h5>Customer Name</h5>
                                            <h5>Customer Mobile</h5>
                                        </div>
                                        <div class="col-lg-7 text-left" style="padding:0px;">
                                            <div>: <input id="c_name" style="border:hidden; width:220px;"
                                                value="{{ Session::get('c_name') }}" readonly>
                                            </div>
                                            <div>: <input id="c_phone" style="border:hidden; width:180px;"
                                                value="{{ Session::get('c_phone') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 row">
                                        <div class="col-lg-5 text-left" style="padding:0px;">
                                            <h5>Pickup Date</h5>
                                            <h5>Pickup Time</h5>
                                        </div>
                                        <div class="col-lg-7 text-left" style="padding:0px;">
                                            <div>: <input id="p_date" style="border:hidden; width: 100px;"
                                                value="{{ Session::get('p_date') }}" readonly>
                                            </div>
                                            <div>: <input id="p_time" style="border:hidden; width: 100px;"
                                                value="{{ Session::get('p_time') }}" readonly>
                                            </div>
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
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-center">Weight</th>
                                                        <th class="text-right">Price (Tk)</th>
                                                        <th class="text-right">Total (Tk)</th>
                                                    </tr>
                                                    <?php $s = 1; ?>
                                                    <tr>
                                                        <td>{{ $s++ }}.</td>
                                                        <td>Jewelery Title 1</td>
                                                        <td>
                                                            {{-- <button class="pd-setting">Active</button> --}}
                                                        </td>
                                                        <td class="text-center">50</td>
                                                        <td class="text-center">15</td>
                                                        <td class="text-right">750</td>
                                                        <td class="text-right">1750</td>
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
                                                            <td class="text-left">COD Charge (1%)</td>
                                                            <td class="text-right">Tk. 0</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">Insurance Amount (1%)</td>
                                                            <td class="text-right">Tk. 90</td>
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
                            </div>
                            {{-- <hr> --}}
                            <div class="text-center ">
                                {{--  <button type="button" class="btn btn-info">
                                    Back <i class="fa fa-arrow-circle-left"></i>
                                </button>  --}}
                                <button type="button" class="btn btn-warning">
                                    Draft 
                                    {{--  <i class="fa fa-times-circle"></i>  --}}
                                </button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Order Confirm 
                                    {{--  <i class="fa fa-check-circle"></i>  --}}
                                </button>
                            </div>
                        </div>
                        
                        {{--  <div class="product-tab-list tab-pane fade" id="netbanking">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="review-content-section">
                                                <select class="form-control mg-b-15">
                                                        <option>Select Bank</option>
                                                        <option>State bank of india</option>
                                                        <option>Bank of baroda</option>
                                                        <option>Central bank of india</option>
                                                        <option>Punjab national bank</option>
                                                        <option>Yes bank</option>
                                                        <option>Kotak mahindra bank</option>
                                                    </select>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light mg-b-15">Submit</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-tab-list tab-pane fade" id="cod">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <input name="number" type="text" class="form-control" placeholder="First Name">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Last Name">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Address">
                                                </div>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" placeholder="Pincode">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <select class="form-control">
                                                            <option>Select country</option>
                                                            <option>India</option>
                                                            <option>Pakistan</option>
                                                            <option>Amerika</option>
                                                            <option>China</option>
                                                            <option>Dubai</option>
                                                            <option>Nepal</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control">
                                                            <option>Select state</option>
                                                            <option>Gujarat</option>
                                                            <option>Maharastra</option>
                                                            <option>Rajastan</option>
                                                            <option>Maharastra</option>
                                                            <option>Rajastan</option>
                                                            <option>Gujarat</option>
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control">
                                                            <option>Select city</option>
                                                            <option>Surat</option>
                                                            <option>Baroda</option>
                                                            <option>Navsari</option>
                                                            <option>Baroda</option>
                                                            <option>Surat</option>
                                                        </select>
                                                </div>
                                                <input type="number" class="form-control" placeholder="Mobile no.">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="payment-adress">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mg-b-15">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#order_place').on('submit', function (e) {
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
                'category'          : $("#category").val(),
                'product'           : $("#pro_title").val(),
                'weight'            : $("#weight").val(),
                'collection'        : $("#collection").val(),
            },
            success: function () {
                {{--  location.reload();  --}}
                {{--  alert('Order Placed Successfully');  --}}
                {{--  location.href= "{{ route('order.preview') }}";  --}}
                {{--  window.location.href= "{{ url('order/create') }}#details";  --}}
            },
            error: function (error) {
                console.log(error);
                alert('Data Not Saved');
            }
        });
    });
</script>

<script>
    $('.productId').on('click',function () {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ route('order.product.find') }}",
            data: {id: id},
            success: function (data) {
                $('.id').val(data[0]['id']);
                $('.title').val(data[0]['title']);
                $('.category').val(data[0]['cat_name']);
                $('.unit_price').val(data[0]['unit_price']);
                $('.quantity').val(data[0]['quantity']);
                $('.weight').val(data[0]['weight']);
                {{--  location.reload();  --}}
            }
        });
    });
</script>

@endsection
