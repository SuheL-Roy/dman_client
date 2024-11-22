@extends('Master.main')
@section('title')
    Pick Up Request Assign
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
                                    PickUp Request <small> (Assign Confirmation) </small>
                                </h1>
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
                        <form class="" method="post" action="{{ route('request.assign.confirm.pickUP') }}">
                            @csrf
                            <div class="col-lg-2">
                                <select name="rider" class="form-control" required>
                                    <option value="">Select Rider</option>
                                    @foreach ($user as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
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
                                        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th> <input type="checkbox" class="selectall"></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="pickup_date" data-editable="false">Pickup Date</th>
                                                <th data-field="pickup_time" data-editable="false">Pickup Time</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                {{--                <th data-field="order_id" data-editable="false">Order ID</th> --}}
                                                <th data-field="m_name" data-editable="false">Merchant Name</th>
                                                {{-- <th data-field="m_shop_name" data-editable="false">S. Name</th> --}}
                                                <th data-field="m_phone" data-editable="false">Merchant Phone</th>
                                                <th data-field="m_address" data-editable="false">Merchant Address</th>
                                                <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                <th data-field="customer_mobile_no" data-editable="false">Customer Phone</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address</th>
                                                <th data-field="type" data-editable="false">Type</th>
                                                <th data-field="destination" data-editable="false">Destination</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($order as $data)
                                                <tr>
                                                    <td><input type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->pickup_date ? date('d-m-Y', strtotime($data->pickup_date)) : 'Not Found ' }}
                                                    </td>
                                                    <td>{{ $data->pickup_time ?? 'Not Found' }}</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    {{--    <td>{{ $data->order_id }}</td> --}}
                                                    <td>{{ $data->business_name }}</td>
                                                    {{-- <td>{{ $data->shop_name }}</td> --}}
                                                    <td>{{ $data->mobile }}</td>
                                                    <td>{{ $data->address }}</td>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>
                                                        @if ($data->type == 'Urgent')
                                                            One Hour
                                                        @elseif ($data->type == 'Regular')
                                                            Regular
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->area }}</td>
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
