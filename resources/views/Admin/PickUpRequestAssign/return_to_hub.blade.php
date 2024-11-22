@extends('Master.main')
@section('title')
    Rteurn to hub
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h5 class="col-lg-2" style="padding:0px;">
                                    Rteurn to transfer to Hub 
                                </h5>
                                <div class="container col-lg-1">
                                    <a target="blank__" href="{{ route('admin.return.to.hub_index_scan') }}" type="btn"
                                    class="btn btn-success">Return To hub By Scan</a>
                                </div>

                                <div class="container col-lg-1">

                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif

                                </div>

                                <form class="" method="post" action="{{ route('admin.return.to.hub_index') }}">
                                    @csrf

                                    <div class="col-lg-2">

                                        <select name="area" class="form-control area" required>
                                            <option value="">Select Destination Hub</option>
                                            @foreach ($area_list as $value)
                                                <option value="{{ $value->zone_name }}"
                                                    {{ $area == $value->zone_name ? 'selected' : '' }}>
                                                    {{ $value->zone_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-lg-2">

                                        <select name="type" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="1" {{ $type == 1 ? 'selected' : '' }}>For Delivery</option>
                                            <option value="2"{{ $type == 2 ? 'selected' : '' }}>For Return</option>

                                        </select>
                                    </div> --}}

                                    <button type="submit" class="col-lg-1 btn btn-info btn-sm">
                                        Load
                                    </button>

                                </form>




                            </div>
                        </div>



                        <form class="" method="post" action="{{ route('admin.return.to.store') }}">
                            @csrf

                            <input type="hidden" name="area" value="{{ $area ?? '' }}" />


                            <div class="col-lg-2">
                                <select name="rider" class="form-control" required>
                                    <option value="">Select Rider</option>
                                    @foreach ($user as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success col-lg-1" style="float:left;"
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
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                {{--                <th data-field="order_id" data-editable="false">Order ID</th> --}}
                                                <th data-field="merchant" data-editable="false">Merchant</th>
                                                <th data-field="business_name" data-editable="false">Business Name</th>
                                                <th data-field="mobile_no" data-editable="false">Mobile No.</th>
                                                <th data-field="customer_name" data-editable="false">Customer</th>
                                                <th data-field="customer_mobile_no" data-editable="false">Customer Mobile
                                                    No.</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                <th data-field="type" data-editable="false">Type</th>
                                                <th data-field="area" data-editable="false">Area</th>
                                                <th data-field="pickup_date" data-editable="false">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>

                                            @foreach ($order as $data)
                                                <tr>
                                                    <td><input type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    {{--    <td>{{ $data->order_id }}</td> --}}
                                                    <td>{{ $data->merchant }}</td>
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
                                                    <td>{{ $area }}</td>
                                                    <td>{{ $data->status }}</td>

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
