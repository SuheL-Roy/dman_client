@extends('Master.main')
@section('title')
Merchant Payment History Report Date Wise
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                            <h1 class="text-center">
                               Transfer Order list
                            </h1>
                            <div class="text-center">
                                <h4> From: {{ $transfer->sender->address }} &nbsp; To: {{ $transfer->receiver->address }} </h4>
                                <h4> Rider: {{ $transfer->media->name }} </h4>
                                <a class="btn btn-primary" href="{{ route('delivery.assign.transfered.print', $transfer->id) }}">print</a>
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="false" data-show-columns="false"
                    data-show-pagination-switch="false" data-show-refresh="false" data-key-events="true"
                    data-show-toggle="false" data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                    data-show-export="false" data-click-to-select="true" data-toolbar="#toolbar">
                    <thead>
                        <tr>
                            <th data-field="sl">SL.</th>
                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                            <th data-field="s_name" data-editable="false">Merchant Name</th>
                            <th data-field="s_phone" data-editable="false">Merchant Phone</th>
                            <th data-field="s_address" data-editable="false">Merchant Address</th>
                            <th data-field="c_name" data-editable="false">Customer Name</th>
                            <th data-field="c_phone" data-editable="false">Customer Phone</th>
                            <th data-field="c_address" data-editable="false">Customer Address</th>
                            <th data-field="type" data-editable="false">Type</th>
                            <th data-field="partial" data-editable="false">Partial</th>
                            <th data-field="collection" data-editable="false">Collection</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trackingDetails as $key => $tracking)
                            <tr>
                                <td>{{ $key + 1 }}.</td>
                                <td> {{ $tracking->tracking_id }} </td>
                                <td> {{ $tracking->business_name }} </td>
                                <td> {{ $tracking->mobile }} </td>
                                <td> {{ $tracking->address }} </td>
                                <td> {{ $tracking->customer_name }} </td>
                                <td> {{ $tracking->customer_phone }} </td>
                                <td> {{ $tracking->customer_address }} </td>
                                <td> {{ $tracking->type == 'Urgent' ? 'One Hour' : 'Regular' }} </td>
                                <td> {{ $tracking->isPartial == 0 ? 'Not Avaiable' : 'Avaiable' }} </td>
                                <td> {{ $tracking->colection }} </td>
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
