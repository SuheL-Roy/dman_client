@extends('Master.main')
@section('title')
    Transfer Head Office
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-3" style="padding:0px;">
                                    Transfer to Fulfillment <small> </small>
                                </h1>
                                <div class="container col-lg-1">
                                    <a target="blank__" href="{{ route('order.transfer.head_office_scan') }}" type="btn"
                                    class="btn btn-success">Transfer to Fulfillment By Scan</a>
                                </div>
                                <div class="container col-lg-2">
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
                        <form class="" method="post" action="{{ route('order.transfer.headoffice') }}">
                            @csrf

                            <div class="col-lg-2">
                                <select name="status" class="form-control status" required>
                                    <option value="For Delivery"
                                        {{ $status == 'Received by Pickup Branch' || $status == '' ? 'Selected' : '' }}>For
                                        Delivery
                                    </option>
                                    <option value="For Return" {{ $status == 'For Return' ? 'Selected' : '' }}>For Return
                                    </option>

                                </select>
                            </div>

                            <button type="submit" class="col-lg-1 btn btn-info btn-sm">
                                Load
                            </button>

                        </form>




                        <form class="" method="post" action="{{ route('order.transfer.headoffice.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="{{ $status }}">
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
                                                <th><input type="checkbox" class="selectall" /></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                <th data-field="business_name" data-editable="false">Business Name</th>
                                                <th data-field="mobile_no" data-editable="false">Merchant Number</th>
                                                <th data-field="customer_name" data-editable="false">Customer</th>
                                                <th data-field="customer_mobile_no" data-editable="false">Customer Mobile
                                                    No.</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                <th data-field="type" data-editable="false">Type</th>
                                                <th data-field="area" data-editable="false">Destination</th>
                                                @if ($status != 'For Return')
                                                    <th data-field="action" data-editable="false">Action</th>
                                                @endif


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>

                                            @foreach ($order as $data)
                                                <tr>
                                                    <td>&nbsp &nbsp<input type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    <td>{{ $data->merchant_info->business_name }}</td>
                                                    <td>{{ $data->user_info->mobile }}</td>
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
                                                    @if ($status != 'For Return')
                                                        <td>
                                                            <a href="{{ route('order.collect.cancel.inhub', ['id' => $data->tracking_id]) }}"
                                                                class="btn btn-danger"
                                                                onclick="return confirm('Are You Sure To Cancel This Order ??')"
                                                                title="Cancel Order ??"><i class="fa fa-close"></i>
                                                                CANCEL</a>

                                                        </td>
                                                    @endif

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
