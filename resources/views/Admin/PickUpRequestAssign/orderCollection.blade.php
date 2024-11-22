@extends('Master.main')
@section('title')
    Order List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">
                                    Order List <small> ( Collection In Hub ) </small>
                                </h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <form class="" method="post" action="{{ route('order.collection.load') }}">
                                        @csrf

                                        <div class="col-lg-4">
                                            <select name="rider_id" class="form-control status" required>
                                                <option value="">---select Rider ---</option>
                                                @foreach ($riders as $rider)
                                                    <option value="{{ $rider->user_id }}"
                                                        {{ $selectedRider == $rider->user_id ? 'Selected' : '' }}>
                                                        {{ $rider->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="col-lg-2 btn btn-info btn-sm">
                                            Load
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('order.collect.all.inhub') }}" method="GET">
                            @csrf

                            <p id="text" style="display: none;">
                                <button type="submit" class="btn btn-success " style="float: right;"
                                    onclick="return confirm('Are You Sure ?')"> <i class="fa fa-check"></i> Collect</button>
                            </p>
                            <div class="clearfix"></div>

                            <div class="sparkline13-graph">
                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <div id="toolbar">
                                        <select class="form-control">
                                            <option value="">Export Basic</option>
                                            <option value="all">Export All</option>
                                            <option value="selected">Export Selected</option>
                                        </select>
                                    </div>
                                    <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="selectall" /></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="pickup_time" data-editable="false">Pickup Time</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                <th data-field="business_name" data-editable="false">Merchant Name</th>
                                                <th data-field="mobile" data-editable="false">Merchant Number</th>
                                                <th data-field="Address" data-editable="false">Merchant Address</th>
                                                 <th data-field="Customer_Name" data-editable="false">Customer Name
                                                </th>
                                              
                                                <th data-field="customer_mobile_no" data-editable="false">Customer Mobile
                                                    No.   </th>
                                                    <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                  <th data-field="area" data-editable="false">Destination</th>
                                                <th data-field="rider" data-editable="false">Rider</th>
                                                {{-- <th data-field="collection" data-editable="false">Collection</th>
                                                <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>
                                                <th data-field="pickup_date" data-editable="false">Pickup Date</th> --}}
                                                <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data as $data)
                                                <tr>
                                                    <td><input id="trackings" type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->pickup_date ? date('d-m-Y', strtotime($data->pickup_date)) : ' ' }}
                                                    </td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    <td>{{ $data->merchant_info->business_name ?? '' }}</td>
                                                    <td>{{ $data->user_info->mobile }}</td>
                                                    <td>{{ $data->user_info->address }}</td>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>{{ $data->area }}</td>
                                                    <td>{{ $data->rider_name }}</td>
                                                    
                                                    
                                                    <td>{{ $data->status }}</td>
                                                    <td>
                                                        @if ($data->status == 'Pickup Done')
                                                            <a href="{{ route('order.collect.inhub', ['id' => $data->tracking_id]) }}"
                                                                class="btn btn-xs"
                                                                onclick="return confirm('Are You Sure to Collect this ??')"
                                                                title="Collection In Hub ??">
                                                                <button class="btn btn-success" type="button"><i
                                                                        class="fa fa-check"></i> COLLECT </button>
                                                            </a>


                                                            <a href="{{ route('order.collect.cancel.inhub', ['id' => $data->tracking_id]) }}"
                                                                class="btn btn-xs"
                                                                onclick="return confirm('Are You Sure To Cancel This Order ??')"
                                                                title="Cancel Order ??">
                                                                <button class="btn btn-danger" type="button"><i
                                                                        class="fa fa-close"></i> CANCEL</button>
                                                            </a>

                                                            {{-- <a href="{{ route('order.collect.print', ['id' => $data->tracking_id]) }}"
                                                            class="btn btn-primary btn-xs" target="_blank">
                                                            <i class="fa fa-print"></i>
                                                        </a> --}}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var value = 0;
            $(".select_id").change(function() {
                var text = document.getElementById("text");
                if ($(this).is(":checked")) {
                    text.style.display = "block";
                    value = value + 1;
                    var values = $("input[name='tracking_ids[]']")
                        .map(function() {
                            return $(this).val();
                        })
                        .get();
                    if (value == values.length) {
                        $(".select_id").prop("checked", true);
                    }
                } else if ($(this).is(":not(:checked)")) {
                    value = value - 1;
                    if (value == 0) {
                        $(".select_id").prop("checked", false);
                        text.style.display = "none";
                    }
                }
            });

            $(".selectall").click(function() {
                var text = document.getElementById("text");
                var checked = this.checked;

                if (checked == true) {
                    $(".select_id").prop("checked", true);
                    text.style.display = "block";
                } else {
                    $(".select_id").prop("checked", false);
                    text.style.display = "none";
                }
            });
        });
    </script>
@endsection
