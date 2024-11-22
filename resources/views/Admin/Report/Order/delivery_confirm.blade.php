@extends('Master.main')
@section('title')
    Collected Order Report Date Wise
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
                                    Delivery Report
                                </h1>
                                <form action="{{ route('order.report.delivery.confirm') }}" method="get">
                                    @csrf
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label style="float:right;">Status :</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="status">
                                                    <option> ---select status--- </option>
                                                    <option value="Successfully Delivered" {{ $filtering === 'Successfully Delivered' ? 'selected' : '' }}>
                                                        Successfully
                                                        Delivered
                                                    </option>
                                                    <option value="Pickup Done" {{ $filtering === 'Pickup Done' ? 'selected' : '' }}>
                                                        Pickup Done
                                                    </option>

                                                    <option value="Partially Delivered" {{ $filtering === 'Partially Delivered' ? 'selected' : '' }}>
                                                        Partial Delivered</option>
                                                    <option value="Cancel Order" {{ $filtering === 'Cancel Order' ? 'selected' : '' }}>Cancel Order
                                                    </option>
                                                    <option value="Reschedule Order" {{ $filtering === 'Reschedule Order' ? 'selected' : '' }}>Reschedule
                                                        Order</option>
                                                    <option value="Hold Order" {{ $filtering === 'Hold Order' ? 'selected' : '' }}>Hold Order
                                                    </option>
                                                    <option value="PickUp Cancel" {{ $filtering === 'PickUp Cancel' ? 'selected' : '' }}>Pickup Cancel
                                                    </option>
                                                </select>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="col-lg-1 btn btn-success btn-sm">Load</button>
                                </form>
                                {{--  <form action="{{ route('order.report.datewise.print') }}" method="get"
                                class="col-lg-1" style="float:right;" target="_blank"> 
                                @csrf
                                <input type="hidden" name="fromdate" value="{{ $fromdate }}"/>
                                <input type="hidden" name="todate" value="{{ $todate }}"/>
                                <button type="submit" class="btn btn-primary btn-sm"
                                    style="float:right;">
                                    <i class="fa fa-print"></i>
                                </button>
                            </form>  --}}
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
                                            <th data-field="m_b_name" data-editable="false">Merchant Name</th>
                                            {{-- <th data-field="m_b_address" data-editable="false">Merchant Address</th> --}}

                                            <th data-field="c_name" data-editable="false"> Customer Name</th>
                                            <th data-field="c_phone" data-editable="false"> Customer Phone</th>
                                            <th data-field="c_address" data-editable="false"> Customer Address</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="collection" data-editable="false"> Invoice Value</th>
                                            <th data-field="collect" data-editable="false"> Collected Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->tracking_id }}</td>
                                                <td>{{ $order->business_name }}</td>
                                                {{-- <td>{{ $order->shop_name }}</td> --}}
                                                <td>{{ $order->customer_name }}</td>
                                                <td>{{ $order->customer_phone }}</td>
                                                <td>{{ $order->customer_address }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>{{ $order->collection }}</td>
                                                <td>{{ $order->collect }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="9" style="text-align:right;">Total Quantity :</td>
                                            <td style="text-align:center;">{{ $Qty }}</td>
                                            <td colspan="1" style="text-align:right;">Total :</td>
                                            <td style="text-align:center;">{{ $Total }}</td>
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
