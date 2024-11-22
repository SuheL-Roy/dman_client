@extends('Master.main')
@section('title')
    Dashboard
@endsection
@section('content')
<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-4" style="padding:0px;">Confirmed Order List</h1>                           
                        </div>
                    </div>
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
                                data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="sl">SL.</th>
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                        {{--   <th data-field="order_id" data-editable="false">Order ID</th> --}}
                                        {{-- @cannot('activeMerchant')
                                            <th data-field="business_name" data-editable="false">Business Name</th>
                                            <th data-field="merchant_no" data-editable="false">Merchant No.</th>
                                        @endcannot --}}
                                        <th data-field="s_name" data-editable="false">S. Name</th>
                                        <th data-field="customer_name" data-editable="false">C. Name</th>
                                        <th data-field="customer_phone" data-editable="false">C. Mobile</th>
                                        <th data-field="destination" data-editable="false">Destination</th>
                                        <th data-field="customer_address" data-editable="false">C. Address</th>
                                        <th data-field="collection" data-editable="false">Collection</th>
                                        <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>
                                        <!-- <th data-field="partial_delivery" data-editable="false">Partial Delivery</th> -->
                                        <th data-field="pickup_date" data-editable="false">Pickup Date</th>
                                        @cannot('superAdmin')
                                            <th data-field="pickup_time" data-editable="false">Pickup Time</th>
                                        @endcannot
                                        <th data-field="status" data-editable="false">Status</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($data as $data)
                                        <tr>
                                            <td></td>
                                            <td>{{ $i++ }}.</td>
                                            <td>{{ $data->tracking_id }}</td>
                                            {{--   <td>{{ $data->order_id }}</td> --}}
                                            {{-- @cannot('activeMerchant')
                                                <td>{{ $data->merchant_info->business_name }}</td>
                                                <td>{{ $data->user_info->mobile }}</td>
                                            @endcannot --}}

                                            <td>{{ $data->shop }}</td>
                                            <td>{{ $data->customer_name }}</td>
                                            <td>{{ $data->customer_phone }}</td>
                                            <td>{{ $data->area }}</td>
                                            <td>{{ $data->customer_address }}</td>
                                            <td>{{ $data->collection }}</td>
                                            <td>{{ $data->merchant_pay }}</td>
                                            <!-- <td>{{ $data->isPartial ? 'Available' : 'Not Available' }}</td> -->
                                            <td>{{ $data->pickup_date ? date('d-m-Y', strtotime($data->pickup_date)) : ' ' }}
                                            </td>
                                            @cannot('superAdmin')
                                                <td>{{ $data->pickup_time }}</td>
                                            @endcannot
                                            <td>{{ $data->status }}</td>
                                            <td class="datatable-ct">
                                                <a href="{{ route('order.confirm_edit', ['id' => $data->tracking_id]) }}"
                                                    class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="{{ route('order.view', ['id' => $data->tracking_id]) }}"
                                                    class="btn btn-info btn-xs" target="_blank">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('order.print', ['id' => $data->tracking_id]) }}"
                                                    class="btn btn-primary btn-xs" target="_blank">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection