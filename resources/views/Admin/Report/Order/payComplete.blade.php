@extends('Master.main')
@section('title')
    Order Report Payment Complete
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
                                Order Report <small>( Payment Complete )</small>
                            </h1>
                            <form action="{{ route('order.report.pay.complete') }}" method="get">
                                @csrf
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label style="float:right;">From :</label>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="date" name="fromdate" required
                                                value="{{ $fromdate }}" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <label style="float:right;">To :</label>
                                        </div>
                                        <div class="col-lg-7">
                                            <input type="date" value="{{ $todate }}" 
                                                class="form-control" name="todate" required/>
                                        </div>
                                        <button type="submit"class="btn btn-success btn-sm">Load</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('order.report.pay.complete.print') }}" method="get"
                                style="float:right;" target="_blank"> @csrf
                                <input type="hidden" name="fromdate" value="{{ $fromdate }}"/>
                                <input type="hidden" name="todate" value="{{ $todate }}"/>
                                <button type="submit" class="btn btn-primary btn-sm"
                                    style="float:right;">
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
                            <table id="table" data-toggle="table" data-pagination="true" 
                                    data-search="true" data-show-columns="true" 
                                    data-show-pagination-switch="true" data-show-refresh="true" 
                                    data-key-events="true" data-show-toggle="true" 
                                    data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" 
                                    data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="sl">SL.</th>
                                        <th data-field="date" data-editable="false">Date</th>
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                        <th data-field="order_id" data-editable="false">Order ID</th>
                                        @can('activeAccounts')
                                        <th data-field="merchant" data-editable="false">Merchant</th>
                                        <th data-field="phone" data-editable="false">Phone</th>
                                        @endcan
                                        <th data-field="customer_name" data-editable="false">Customer</th>
                                        <th data-field="customer_phone" data-editable="false">Mobile</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="collection" data-editable="false">Collection</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($order as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->tracking_id }}</td>
                                        <td>{{ $data->order_id }}</td>
                                        @can('activeAccounts')
                                        <td>{{ $data->merchant }}</td>
                                        <td>{{ $data->phone }}</td>
                                        @endcan
                                        <td>{{ $data->customer_name }}</td>
                                        <td>{{ $data->customer_phone }}</td>
                                        <td>{{ $data->area }}</td>
                                        <td>{{ $data->collection }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        @can('activeAccounts')
                                        <td></td>
                                        <td></td>
                                        @endcan
                                        <td colspan="8" style="text-align:right;">Total :</td>
                                        <td> &nbsp; {{ $Total }}</td>
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