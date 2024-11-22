@extends('Master.main')
@section('title')
    Rider History
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-12 form-group" style="padding:0px;">
                                    Rider History <small>( Rider & Status Wise )</small>
                                </h1>
                                <form action="{{ route('order.report.rider.status.date.print') }}" method="get"
                                    class="col-lg-1" style="float:right;" target="_blank">
                                    @csrf
                                    <input type="hidden" name="rider" value="{{ $rider }}" />
                                    <input type="hidden" name="status" value="{{ $status }}" />
                                    <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                    <input type="hidden" name="todate" value="{{ $todate }}" />
                                    <button type="submit" class="btn btn-primary" style="float:right;">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </form>
                                <form action="{{ route('order.report.rider.status.date') }}" method="get">
                                    @csrf
                                    <div class="col-lg-2">
                                        <select name="rider" class="selectpicker form-control" title="Select Rider"
                                            data-style="btn-info" data-live-search="true" required>
                                            {{--  <option value="">Select Rider</option>  --}}
                                            @foreach ($user as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ $data->id == $rider ? 'selected' : '' }}>{{ $data->name }} -
                                                    (R{{ $data->id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="status" class="form-control" title="Select Status">
                                            {{-- <select class="form-control" name="status"> --}}
                                            <option value=""> ---select status--- </option>
                                            <option value="Successfully Delivered"
                                                {{ $filtering === 'Successfully Delivered' ? 'selected' : '' }}>
                                                Successfully
                                                Delivered
                                            </option>
                                            <option value="Assigned To Delivery Rider"
                                                {{ $filtering === 'Assigned To Delivery Rider' ? 'selected' : '' }}>
                                                Assigned To Delivery Rider
                                            </option>
                                            <option value="Pickup Done"
                                                {{ $filtering === 'Pickup Done' ? 'selected' : '' }}>
                                                Pickup Done
                                            </option>

                                            <option value="Partially Delivered"
                                                {{ $filtering === 'Partially Delivered' ? 'selected' : '' }}>
                                                Partial Delivered</option>
                                            <option value="Cancel Order"
                                                {{ $filtering === 'Cancel Order' ? 'selected' : '' }}>Cancel Order
                                            </option>
                                            <option value="Reschedule Order"
                                                {{ $filtering === 'Reschedule Order' ? 'selected' : '' }}>Reschedule
                                                Order</option>
                                            <option value="Hold Order" {{ $filtering === 'Hold Order' ? 'selected' : '' }}>
                                                Hold Order
                                            </option>
                                            <option value="PickUp Cancel"
                                                {{ $filtering === 'PickUp Cancel' ? 'selected' : '' }}>Pickup Cancel
                                            </option>
                                            {{-- </select> --}}
                                        </select>
                                    </div>
                                    {{--  <div class="col-lg-3"></div>  --}}
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">From:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" name="fromdate" required value="{{ $fromdate }}"
                                                    class="form-control" style="padding-left: 7px;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label style="float:right;">To:</label>
                                            </div>
                                            <div class="col-lg-10">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="col-lg-1 btn btn-success btn-sm" style="float:right;">Load
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
                                            <th data-field="sl">SL.</th>
                                            <th data-field="tracking_id">Tracking ID</th>
                                            <th data-field="rider" data-editable="false">Rider Name</th>
                                            <th data-field="shop_name" data-editable="false">Merchant Name</th>
                                            <th data-field="merchent_phone" data-editable="false">Merchant Phone</th>
                                            <th data-field="customer_name" data-editable="false">Customer Name</th>
                                            <th data-field="customer_phone" data-editable="false">Customer Phone</th>
                                            <th data-field="customer_address" data-editable="false">Customer Address</th>
                                            <th data-field="note" data-editable="false">Note</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="invoice" data-editable="false">Invoice Value</th>
                                            <th data-field="camount" data-editable="false">Collected Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        $sdQty = 0; ?>
                                        @foreach ($order as $order)
                                            <tr>
                                                <td>{{ $i += 1 }}.</td>
                                                <td>{{ $order->tracking_id }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->business_name }}</td>
                                                <td>{{ $order->merchants_phone }}</td>
                                                <td>{{ $order->customer_name }}</td>
                                                <td>{{ $order->customer_phone }}</td>
                                                <td>{{ $order->customer_address }}</td>
                                                <td>{{ $order->delivery_note ?? 'NULL' }}</td>
                                                <td>{{ $order->status }}</td>
                                                <span style="display:none;">
                                                    @php $order->status=='Successfully Delivered'?++$sdQty:'' @endphp
                                                </span>
                                                <td>{{ $order->colection ?? '' }}</td>
                                                <td>{{ $order->collect }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    {{--  <tfoot>
                                    <tr>
                                        <td colspan="9" style="text-align:right;">Total Order :</td>
                                        <td> &nbsp; {{ $Qty }}</td>
                                    </tr>
                                </tfoot>  --}}
                                    <tfoot>
                                        <tr>
                                            <td colspan="8" style="text-align:right;">Total Order :</td>
                                            <td> &nbsp; {{ $Qty }}</td>
                                            <td style="text-align:right;">Successful Ratio :</td>
                                            <td> &nbsp; @if ($Qty > 0)
                                                    {{ ($sdQty / $Qty) * 100 }}%
                                                @endif
                                            </td>
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
