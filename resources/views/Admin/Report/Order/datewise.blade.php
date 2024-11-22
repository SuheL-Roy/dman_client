@extends('Master.main')
@section('title')
    Order Report Date Wise
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-2" style="padding:0px;">
                                    Order History
                                </h1>
                                <form action="{{ route('order.report.datewise') }}" method="get">
                                    @csrf
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">Status</label>
                                            </div>
                                            <div class="col-lg-7">
                                                <select name="status" class="form-control">
                                                    <option> ---select status--- </option>
                                                    <option value="Payment Paid"
                                                        {{ $orderStatus === 'Payment Paid' ? 'selected' : '' }}> Payment
                                                        Paid
                                                    </option>
                                                    <option value="Payment Due"
                                                        {{ $orderStatus === 'Payment Due' ? 'selected' : '' }}> Payment Due
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="date" name="fromdate" required value="{{ $fromdate }}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                            <button type="submit"class="btn btn-success btn-sm">Load</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="{{ route('order.report.datewise.print') }}" method="get" class="col-lg-1"
                                    style="float:right;" target="_blank">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $orderStatus }}" />
                                    <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                    <input type="hidden" name="todate" value="{{ $todate }}" />
                                    <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
                                        <i class="fa fa-print"></i>
                                        print
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
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            {{-- <th data-field="s_name" data-editable="false">S. Name</th>
                                            <th data-field="shop_name" data-editable="false">S. Address</th> --}}
                                            <th data-field="customer_name" data-editable="false">Customer Name</th>
                                            <th data-field="customer_phone" data-editable="false">Customer Mobile</th>
                                            <th data-field="destination" data-editable="false">Destination</th>
                                            <th data-field="customer_address" data-editable="false">Customer Address</th>
                                            <th data-field="collection" data-editable="false">Invoice Value</th>
                                            <th data-field="merchant_pay" data-editable="false">Collected Amount</th>
                                            {{-- <th data-field="pickup_time" data-editable="false">Delivery Date</th> --}}
                                            <th data-field="note" data-editable="false">Remarks</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            @can('superAdmin')
                                                <th data-field="action">Action</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order as $key => $data)
                                            <tr>
                                                <td></td>
                                                <td><b>{{ $key + 1 }}.</b></td>
                                                <td><a href="{{ route('order.view', ['id' => $data->tracking_id]) }}"
                                                        target="_blank"><b
                                                            style="color: rgb(244, 28, 8)">{{ $data->tracking_id }}</b></a>
                                                </td>
                                                {{-- <td><b>{{ $data->shop }}</b></td>
                                                <td><b>{{ $data->created_at }}</b></td> --}}
                                                <td><b>{{ $data->customer_name }}</b></td>
                                                <td><b>{{ $data->customer_phone }}</b></td>
                                                <td><b>{{ $data->area }}</b></td>
                                                <td><b>{{ $data->customer_address }}</b></td>
                                                <td><b>{{ $data->collection }}</b></td>
                                                <td><b>{{ $data->collect }}</b></td>
                                                <td><b>({{ $data->delivery_date }} ){{ $data->delivery_note }}</b>
                                                </td>
                                                <td><b>{{ $data->status }}</b></td>
                                                @can('superAdmin')
                                                    <td class="datatable-ct">
                                                        <a href="{{ route('order.confirm_edit', ['id' => $data->tracking_id]) }}"
                                                            class="btn ">

                                                            <button class="btn btn-info"><i class="fa fa-edit"></i> Edit
                                                            </button>
                                                        </a>
                                                        <a href="{{ route('order.collect.print', ['id' => $data->tracking_id]) }}"
                                                            class="btn" target="_blank">

                                                            <button class="btn btn-success"><i class="fa fa-print"></i> Print
                                                            </button>
                                                        </a>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="7" style="text-align:right; font-weight:bold;">Total :</td>
                                            <td style="text-align: center;font-weight:bold;">{{ $total_collection }}</td>
                                            <td style="text-align: center;font-weight:bold;">{{ $total_collect }}</td>
                                            <td></td>
                                            <td></td>
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
