@extends('Master.main')
@section('title')
    Rider Wise PickUp Collect / Cancel Report
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
                                    Order List <small>( Rider Wise PickUp Collect / Cancel )</small>
                                </h1>
                                <form action="{{ route('order.report.riderwise') }}" method="get">
                                    @csrf
                                    <div class="col-lg-3">
                                        <select name="rider" class="selectpicker form-control" title="Select Rider"
                                            data-style="btn-info" data-live-search="true" required>
                                            {{--  <option value="">Select Rider</option>  --}}
                                            @foreach ($user as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }} -
                                                    (R{{ $data->id }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select name="status" class="form-control" title="Select Status" required>
                                            <option value="">Select Statusaaa</option>
                                            <option value="Order Collect">Order Collect</option>
                                            <option value="PickUp Cancel">PickUp Cancel</option>
                                            {{--  <option value="Delivery Pending">Delivery Pending</option>
                                        <option value="Order Delivered">Order Delivered</option>  --}}
                                        </select>
                                    </div>
                                    <button type="submit" class="col-lg-1 btn btn-success btn-sm">
                                        Load
                                    </button>
                                </form>
                                <form action="{{ route('order.report.riderwise.print') }}" method="get" class="col-lg-1"
                                    style="float:right;" target="_blank">
                                    @csrf
                                    <input type="hidden" name="rider" value="{{ $rider }}" />
                                    <input type="hidden" name="status" value="{{ $status }}" />
                                    <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

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
                                            <th data-field="date" data-editable="false">Date</th>
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            <th data-field="orderid" data-editable="false">Order ID</th>
                                            <th data-field="merchant" data-editable="false">Merchant</th>
                                            <th data-field="pickup_date" data-editable="false">PickUp Date</th>
                                            <th data-field="colection" data-editable="false">Collection</th>
                                            {{--  <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>  --}}
                                            <th data-field="status" data-editable="false">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($order as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->date }}</td>
                                                <td>{{ $data->tracking_id }}</td>
                                                <td>{{ $data->order_id }}</td>
                                                <td>{{ $data->merchant }}</td>
                                                <td>{{ $data->pickup_date }}</td>
                                                <td>{{ $data->collection }}</td>
                                                {{--  <td>{{ $data->merchant_pay }}</td>  --}}
                                                <td>{{ $data->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td colspan="7" style="text-align:right;">Total Order :</td>
                                            <td>&nbsp; {{ $Qty }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
