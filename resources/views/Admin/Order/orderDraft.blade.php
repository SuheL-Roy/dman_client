@extends('Master.main')
@section('title')
    Draft Order List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Draft Order List</h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
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
                                            <th data-field="order_id" data-editable="false">Order ID</th>
                                            <th data-field="customer_name" data-editable="false">Customer</th>
                                            <th data-field="customer_phone" data-editable="false">Mobile</th>
                                            <th data-field="collection" data-editable="false">Collection</th>
                                            <th data-field="partial_delivery" data-editable="false">Partial Delivery</th>
                                            <th data-field="pickup_date" data-editable="false">Pickup Date</th>
                                            <th data-field="pickup_time" data-editable="false">Pickup Time</th>
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
                                                <td>{{ $data->order_id }}</td>
                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->customer_phone }}</td>
                                                <td>{{ $data->collection }}</td>
                                                <td>{{ $data->isPartial ? 'Available' : 'Not Available' }}</td>
                                                <td>{{ $data->pickup_date ? date('d-m-Y', strtotime($data->pickup_date)) : ' ' }}
                                                </td>
                                                <td>{{ $data->pickup_time }}</td>
                                                <td class="datatable-ct">
                                                    <a href="{{ route('order.draft_edit', ['id' => $data->tracking_id]) }}"
                                                        class="btn btn-primary btn-xs">
                                                        <i class="fa fa-edit"></i>
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
