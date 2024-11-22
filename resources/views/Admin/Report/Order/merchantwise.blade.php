@extends('Master.main')
@section('title')
    Order Report Merchant & Status Wise
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <div class="col-lg-2" style="padding:0px;">
                                    <h4> &nbsp;&nbsp;&nbsp; Merchant History</h4>
                                </div>
                                <form action="{{ route('order.report.merchantwise') }}" method="GET">
                                    @csrf
                                    <div class="col-lg-2">
                                        <select name="merchant" class="selectpicker form-control" 
                                            title="Select Merchant" data-style="btn-info" data-live-search="true">
                                            {{--  <option value="">Select Merchant</option>  --}}
                                            @foreach ($user as $data)
                                                <option value="{{ $data->user_id }}" {{ $merchant == $data->user_id ? 'Selected' : '' }}>{{ $data->business_name }} -
                                                    (M{{ $data->id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select name="status" class="form-control" title="Select Status">
                                             <option value="">Select Status</option>
                                         <option value="Order Placed"  {{ $status == "Order Placed" ? 'Selected' : '' }}>
                                                Order Placed</option>
                                            <option value="Assigned Pickup Rider" {{ $status == "Assigned Pickup Rider" ? 'Selected' : '' }}>Assigned Pickup Rider</option>
                                          <!--   <option value="Waiting for Pickup"> Waiting for Pickup </option> -->
                                            <option value="Pickup Done" {{ $status == "Pickup Done" ? 'Selected' : '' }}>Pickup Done</option>
                                         <!--    <option value="PickUp Cancel">PickUp Cancel</option> -->
                                         
                                            <option value="Assigned To Delivery Rider" {{ $status == "Assigned To Delivery Rider" ? 'Selected' : '' }}>Assigned To Delivery Rider</option>
                                           <!--  <option value="Waiting for Delivery">Waiting for Delivery </option> -->
                                            <!-- <option value="Waiting for Return">Waiting for Return </option> -->


                                           
                                           <!--  <option value="PickUp Cancel">Delivery Complete</option>
                                            <option value="PickUp Cancel">Return Complete</option> -->

                                            <!-- <option value="PickUp Cancel">Hub Hold & Rescheduled</option>
                                            <option value="PickUp Cancel">Hub Return Process</option> -->

                                           <!--  <option value="Assigned Pickup Rider">Hub Transit</option> -->

                                            <option value="Order Cancel by Branch" {{ $status == "Order Cancel by Branch" ? 'Selected' : '' }}>Order Cancel by Branch</option>
                                            <option value="Received by Pickup Branch" {{ $status == "Received by Pickup Branch" ? 'Selected' : '' }}>Received by Pickup Branch</option>
                                            <option value="Reach to Fullfilment"  {{ $status == "Reach to Fullfilment" ? 'Selected' : '' }}>Reach to Fullfilment</option>
                                            <option value="Return Reach For Fullfilment" {{ $status == "Return Reach For Fullfilment" ? 'Selected' : '' }}> Return Reach For Fullfilment
                                            </option>
                                            <option value="Received By Fullfilment" {{ $status == "Received By Fullfilment" ? 'Selected' : '' }}>Received By Fullfilment</option>
                                            <option value="Reach to Branch" {{ $status == "Reach to Branch" ? 'Selected' : '' }}>Reach to Branch</option>
                                            <option value="Return Reach For Branch" {{ $status == "Return Reach For Branch" ? 'Selected' : '' }}>Return Reach For Branch</option>
                                            <option value="Return Received By Destination Hub" {{ $status == "Return Received By Destination Hub" ? 'Selected' : '' }}>Return Received By
                                                Destination Hub</option>
                                            <option value="Received By Destination Hub" {{ $status == "Received By Destination Hub" ? 'Selected' : '' }}>Received By Destination Hub</option>
                                           <!--  <option value="Assigned To Delivery Rider">Assigned To Delivery Rider</option> -->
                                            <option value="Successfully Delivered" {{ $status == "Successfully Delivered" ? 'Selected' : '' }}>Successfully Delivered</option>
                                            <option value="Partially Delivered" {{ $status == "Partially Delivered" ? 'Selected' : '' }}>Partial Delivered</option>
                                            <option value="Cancel Order" {{ $status == "Cancel Order" ? 'Selected' : '' }}>Cancel Order</option>
                                            <option value="Reschedule Order" {{ $status == "Reschedule Order" ? 'Selected' : '' }}>Reschedule Order</option>
                                            <option value="Hold Order" {{ $status == "Hold Order" ? 'Selected' : '' }}>Hold Order</option>
                                        
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
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
                                    <div class="col-lg-2">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label style="float:right;">To:</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="col-lg-1 btn btn-success btn-sm">
                                        Load
                                    </button>
                                </form>
                                {{-- <form action="{{ route('order.report.merchant_wise') }}" method="get" class="col-lg-1"
                                    style="float:right;" target="_blank">
                                    @csrf
                                    <input type="hidden" name="merchant" value="{{ $merchant }}" />
                                    <input type="hidden" name="status" value="{{ $status }}" />
                                    <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
                                        <i class="fa fa-print"></i>
                                    </button>
                                </form> --}}
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
                                            {{-- <th data-field="s_name" data-editable="false">S.Name</th>
                                            <th data-field="dfg" data-editable="false">S. Address</th> --}}
                                            <th data-field="sfs" data-editable="false">Customer Name</th>
                                            <th data-field="rsdfg" data-editable="false">Customer Mobile</th>
                                            <th data-field="wer" data-editable="false">Customer Address</th>
                                            <th data-field="ret" data-editable="false">Destination</th>
                                            <th data-field="were" data-editable="false">Invoice Value</th>
                                            <th data-field="nerwe" data-editable="false">Collected Amount</th>
                                            {{-- <th data-field="wete" data-editable="false">Remarks</th> --}}
                                            <th data-field="dertgy" data-editable="false">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($order as $key => $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $data->tracking_id }}</td>
                                                {{-- <td>{{ $data->shop }}</td>
                                                <td>{{ $data->shop_address }}</td> --}}
                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->customer_phone }}</td>
                                                <td>{{ $data->customer_address }}</td>
                                                <td>{{ $data->area }}</td>
                                                <td>{{ $data->collection }}</td>
                                                <td>{{ $data->collect }}</td>
                                                {{-- <td>{{ $data->remarks ?? 'Null' }}</td> --}}
                                                <td>{{ $data->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8"></td>
                                            <td>Total Order :</td>
                                            <td>{{ $Qty }}</td>
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
