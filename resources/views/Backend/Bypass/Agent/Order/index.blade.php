@extends('Master.main')
@section('title')
    Delivery Assign
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <div class="col-lg-4" style="padding:0px;">
                                    @if ($orders)
                                        <h4>Order bypass list</h4>
                                    @else
                                        <h4 style="color: rgb(250, 4, 4)">Data Not found</h4>
                                    @endif
                                </div>
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
                            </div>
                        </div>


                        <form class="" method="post" action="{{ route('agent.order.bypass.confirm') }}">
                            @csrf

                            <p id="text" style="display:none">
                                <button type="submit" class="btn btn-success col-lg-1" style="float:right;"
                                    onclick="return confirm('Are You Sure ?')">Confirm
                                </button>
                            </p>

                            <div class="clearfix"></div>

                            @if ($orders)
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
                                            data-show-columns="true" data-show-pagination-switch="true"
                                            data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                            data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                                            data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                            <thead>
                                                <tr>
                                                    <th> <input type="checkbox" class="selectall"></th>
                                                    {{-- <th data-field="state" data-checkbox="true"></th> --}}
                                                    <th data-field="sl">SL.</th>
                                                    <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                    <th data-field="business_name" data-editable="false">Merchant Name</th>
                                                    <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                    <th data-field="customer_mobile_no" data-editable="false">Customer
                                                        Mobile
                                                    </th>
                                                    <th data-field="customer_address" data-editable="false">Customer Address
                                                    </th>
                                                    <th data-field="destination" data-editable="false">Destination</th>
                                                    <th data-field="collection" data-editable="false">Invoice Value</th>
                                                    <th data-field="collection" data-editable="false">Type</th>
                                                    <th data-field="status" data-editable="false">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $key => $order)
                                                    <tr>
                                                        <td><input id="trackings" type="checkbox" class="select_id"
                                                                value="{{ $order->tracking_id }}" name="tracking_ids[]" />
                                                        </td>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $order->tracking_id }}</td>
                                                        <td>{{ $order->business_name ?? '' }}</td>
                                                        <td>{{ $order->customer_name }}</td>
                                                        <td>{{ $order->customer_phone }}</td>
                                                        <td>{{ $order->customer_address }}</td>
                                                        <td>{{ $order->destination }}</td>
                                                        <td class="selected_merchant_pay">{{ $order->colection }}</td>
                                                        <td>{{ $order->type=='Urgent'?'One Hour':'Regular' }}</td>
                                                        <td>{{ $order->status }}</td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <img width="1400px" height="200px"
                                    src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-626.jpg?w=2000"
                                    alt="">
                            @endif
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
                        }).get();
                    if (value == values.length) {
                        $('.select_id').prop('checked', true);
                    }


                } else if ($(this).is(":not(:checked)")) {
                    value = value - 1;
                    if (value == 0) {
                        $('.select_id').prop('checked', false);
                        text.style.display = "none";
                    }

                }
            });


            $(".selectall").click(function() {
                var text = document.getElementById("text");
                var checked = this.checked;

                if (checked == true) {
                    $('.select_id').prop('checked', true);
                    text.style.display = "block";
                } else {
                    $('.select_id').prop('checked', false);
                    text.style.display = "none";
                }
            });
        });
    </script>


@endsection
