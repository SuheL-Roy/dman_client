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
                                <h1 class="col-lg-12">Merchant Edit Order</h1>
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
                                <form name="payment-form" action="{{ route('order.confirm.store') }}" method="POST">
                                    @csrf
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <label class="col-lg-4">Tracking ID. *</label>
                                            <div class="form-group col-lg-8">
                                                <input name="tracking_id" value="{{ $order->tracking_id }}"
                                                    class="form-control" readonly style="border:hidden;">
                                            </div>
                                            <label class="col-lg-4">Order ID</label>
                                            <div class="form-group col-lg-8">
                                                <input name="order_id" type="text" class="form-control"
                                                    value="{{ $order->order_id }}" placeholder="Order ID">
                                            </div>
                                            <label class="col-lg-4">Customer Name *</label>
                                            <div class="form-group col-lg-8">
                                                <input type="text" value="{{ $order->customer_name }}"
                                                    class="form-control" name="customer_name" required
                                                    placeholder="Customer Name">
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
                                            {{-- <label class="col-lg-4">Customer Email</label>
                                            <div class="form-group col-lg-8">
                                                <input type="text" value="{{ $order->customer_email }}"
                                                    class="form-control" name="customer_email" placeholder="Customer Email">
                                            </div> --}}


                                            <label class="col-lg-4">Destination *</label>
                                            <div class="form-group col-lg-8">
                                                <select id="area" name="area" class="chosen-select"
                                                    title="Select Area" required>
                                                    <option value=""> Select Area </option>
                                                    @foreach ($area as $data)
                                                        <option value="{{ $data->area }}"
                                                            {{ $order->area == $data->area ? 'selected' : '' }}>
                                                            {{ $data->area }}</option>
                                                    @endforeach
                                                </select>
                                            </div>




                                            <label class="col-lg-4">Collection Amount *</label>
                                            <div class="form-group col-lg-8">
                                                <input class="form-control" id="collection" type="text" name="collection"
                                                    title="Collection Amount" placeholder="Collection Amount" required
                                                    value="{{ $order->collection }}">
                                            </div>

                                            <label class="col-lg-4">Status</label>
                                            <div class="form-group col-lg-8">
                                                <input type="text" required class="form-control" name="status"
                                                    value="{{ $order->status }}" readonly>
                                            </div>











                                        </div>

                                        <div class="col-lg-6">
                                            <label class="col-lg-4">Weight *</label>
                                            <div class="form-group col-lg-8">
                                                <select class="chosen-select" name="weight" id="weight" required>
                                                    <option value=""> --- select weight --- </option>
                                                    @foreach ($weights as $weight)
                                                        <option value="{{ $weight->title }}"
                                                            {{ $order->weight == $weight->title ? 'selected' : '' }}>
                                                            {{ $weight->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <label class="col-lg-4">Category *</label>
                                            <div class="form-group col-lg-8">
                                                <select id="category" class="form-control" name="category"
                                                    title="Select Category" required>
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
                                                    placeholder="Product Title" required>
                                            </div>


                                            <label class="col-lg-4">Delivery Type</label>

                                            <div class="form-group col-lg-8">
                                                <select name="imp" class="imp form-control" required>
                                                    @if ($order->type == 'Urgent')
                                                        <option value="Express">One Hour</option>
                                                        <option value="Regular">Regular</option>
                                                    @else
                                                        <option value="Regular">Regular</option>
                                                        <option value="Express">One Hour</option>
                                                    @endif
                                                </select>
                                            </div>



                                            <label class="col-lg-4">Pickup Date *</label>
                                            <div class="form-group col-lg-8">
                                                <input id="pickup_date" class="form-control" type="date"
                                                    title="Select Pickup Date" name="pickup_date"
                                                    value="{{ $order->pickup_date }}" required>
                                            </div>
                                            <label class="col-lg-4">Pickup Time *</label>
                                            <div class="form-group col-lg-8">
                                                <select id="pickup_time" class="form-control" name="pickup_time"
                                                    title="Select Pickup Time" required>
                                                    @foreach ($pickup as $data)
                                                        <option value="{{ $data->pick_up }}"
                                                            {{ $order->pick_up == $data->pick_up ? 'selected' : '' }}>
                                                            {{ $data->pick_up }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <label class="col-lg-4">Remarks </label>
                                            <div class="form-group col-lg-8">
                                                <textarea class="form-control" name="remarks" placeholder="Remarks">{{ $order->remarks }}</textarea>
                                            </div>



                                            <label class="col-lg-4"> Partial Delivery?</label>
                                            <div class="form-group col-lg-8">
                                                <input type="checkbox" class="form-check-input" id="is_partial"
                                                    name="is_partial" {{ $order->isPartial == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="check1"> On </label>
                                            </div>





                                        </div>

                                    </div>
                                    <hr>
                                    <div class="text-center credit-card-custom">
                                        <button type="submit" class="btn btn-success">
                                            Update <i class="fa fa-check-circle"></i>
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
@endsection
