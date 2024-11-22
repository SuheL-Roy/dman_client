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
                                <h4 class="col-lg-2" style="padding:0px;">
                                    Pickup Bypass @isset($rider->name)
                                    @endisset
                                </h4>
                                <div class="col-lg-4" style="padding:0px;">
                                    <form action="{{ route('agent.pickup.bypass.load') }}">
                                        @csrf
                                        <div class="col-lg-8">
                                            <select name="form_rider" class="form-control" required>
                                                <option value="">Select Rider</option>
                                                @foreach ($riders as $rider)
                                                    <option value="{{ $rider->id }}"
                                                        {{ $rider->id == $form_rider ? 'selected' : '' }}>
                                                        {{ $rider->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info col-lg-3" style="float:right;">Load
                                        </button>
                                    </form>
                                </div>
                                <h4 class="col-lg-2">To</h4>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px;
                                padding-bottom:5px; margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <form class="" method="post" action="{{ route('agent.pickup.bypass.order.pickup') }}">
                                @csrf
                                <input type="hidden" name="form_rider" value="{{ $form_rider }}">
                                <div class="col-lg-3">
                                    <select name="to_rider" class="form-control" required>
                                        <option value="">Select Rider</option>
                                        @foreach ($riders as $rider)
                                            <option value="{{ $rider->id }}">{{ $rider->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success col-lg-1" style="float:right;"
                                    onclick="return confirm('Are You Sure ?')">Confirm
                                </button>
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
                                            data-show-columns="true" data-show-pagination-switch="true"
                                            data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                            data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                                            data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                            <thead>
                                                <tr>

                                                    <th> <input type="checkbox" class="selectall"></th>
                                                    <th data-field="sl">SL</th>
                                                    <th data-field="pickup_date" data-editable="false">Pickup Date</th>
                                                    <th data-field="pickup_time" data-editable="false">Pickup Time</th>
                                                    <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                    <th data-field="m_name" data-editable="false">Merchant Name</th>
                                                    <th data-field="m_phone" data-editable="false">Merchant Phone</th>
                                                    <th data-field="m_address" data-editable="false">Merchant Address</th>
                                                    {{-- <th data-field="m_shop_name" data-editable="false">S. Name</th>
                                                    <th data-field="m_phone" data-editable="false">S. Phone</th>
                                                    <th data-field="m_address" data-editable="false">S. Address</th> --}}
                                                    <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                    <th data-field="customer_mobile_no" data-editable="false">Customer Phone
                                                    </th>
                                                    <th data-field="customer_address" data-editable="false">Customer Address
                                                    </th>
                                                    <th data-field="type" data-editable="false">Type</th>
                                                    <th data-field="destination" data-editable="false">Destination</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $key => $order)
                                                    <tr>
                                                        <td><input type="checkbox" class="select_id"
                                                                value="{{ $order->tracking_id }}" name="tracking_ids[]" />
                                                        </td>
                                                        <td>{{ $key + 1 }}.</td>
                                                        <td>{{ $order->pickup_date ? date('d-m-Y', strtotime($order->pickup_date)) : 'Not Found' }}
                                                        </td>
                                                        <td>{{ $order->pickup_time??'Not Found' }}</td>
                                                        <td>{{ $order->tracking_id }}</td>
                                                        {{--    <td>{{ $order->order_id }}</td> --}}
                                                        <td>{{ $order->business_name }}</td>
                                                        <td>{{ $order->mobile }}</td>
                                                        <td>{{ $order->address }}</td>
                                                        {{-- <td>{{ $order->shop_name }}</td>
                                                        <td>{{ $order->shop_phone }}</td>
                                                        <td>{{ $order->shop_address }}</td> --}}
                                                        <td>{{ $order->customer_name }}</td>
                                                        <td>{{ $order->customer_phone }}</td>
                                                        <td>{{ $order->customer_address }}</td>
                                                        <td>
                                                            @if ($order->type == 'Urgent')
                                                                One Hour
                                                            @elseif ($order->type == 'Regular')
                                                                Regular
                                                            @endif
                                                        </td>
                                                        <td>{{ $order->area }}</td>
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
    </div>


    <script>
        $(document).ready(function() {
            $(".selectall").click(function() {
                var checked = this.checked;
                if (checked == true) {
                    $('.select_id').prop('checked', true);
                } else {
                    $('.select_id').prop('checked', false);
                }
            });
        });
    </script>
@endsection
