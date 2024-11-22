@extends('Master.main')
@section('title')
    Order List
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
                                    Order List <small> ( Return to bypass ) </small>
                                </h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px; text-align:center;">
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
                                            <th data-field="m_name" data-editable="false">Merchant Name</th>
                                            <th data-field="s_phone" data-editable="false">MerchantPhone</th>
                                            <th data-field="s_name" data-editable="false">Merchant Address</th>
                                            <th data-field="c_name" data-editable="false">Customer Name</th>
                                            <th data-field="c_phone" data-editable="false">Customer Phone</th>
                                            <th data-field="c_address" data-editable="false">Customer Address</th>
                                            <th data-field="area" data-editable="false">Destination</th>
                                            <th data-field="collection" data-editable="false">Collection</th>
                                            <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>
                                            <th data-field="status" data-editable="false">Status</th>

                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bypasses as $key => $bypass)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $bypass->tracking_id }}</td>
                                                <td>{{ $bypass->business_name }}</td>
                                                <td>{{ $bypass->mobile }}</td>
                                                <td>{{ $bypass->address }}</td>
                                                <td>{{ $bypass->customer_name }}</td>
                                                <td>{{ $bypass->customer_phone }}</td>
                                                <td>{{ $bypass->customer_address }}</td>
                                                <td>{{ $bypass->area }}</td>
                                                <td>{{ $bypass->colection }}</td>
                                                <td>{{ $bypass->merchant_pay }}</td>
                                                <td>{{ $bypass->status }}</td>
                                                <td>
                                                    <a href="{{ route('admin.bypass.to.return.cancel.aprove', ['id' => $bypass->tracking_id]) }}"
                                                        class="btn "onclick="return confirm('Are You Sure  To Approved This??')" title="Cancel Approved By Fullfilment ??">
                                                       
                                                        <button  class="btn btn-success" ><i class="fa fa-check"></i> Approved  </button>

                                                    </a>

                                                    <a href="{{ route('admin.bypass.to.return.cancel.reject', ['id' => $bypass->tracking_id]) }}"
                                                        class="btn "   onclick="return confirm('Are You Sure  To Reject This??')" title="Reject By Fulfillment ??">
                                                        
                                                        <button  class="btn btn-danger" ><i class="fa fa-close"></i> Reject  </button>

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
