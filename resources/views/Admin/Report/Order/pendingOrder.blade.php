@extends('Master.main')
@section('title')
    Order Report Pending
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
                                Order Report <small>( Hold )</small>
                            </h1>
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
                                        
                                        <th data-field="merchant_name" data-editable="false">M. Name</th>
                                        <th data-field="merchant_phone" data-editable="false">M. Phone</th>
                                        <th data-field="merchant_address" data-editable="false">M. Address</th>


                                        <th data-field="customer_name" data-editable="false">C. Name</th>
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="category" data-editable="false">Category</th>
                                        <th data-field="delivery_note" data-editable="false">Note</th>
                                        <th data-field="colection" data-editable="false">Collection</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($data as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->date }}</td>

                                        <td>{{ $data->business_name }}</td>
                                        <td>{{ $data->shop_phone }}</td>
                                        <td>{{ $data->pickup_address }}</td>

                                        <td>{{ $data->customer_name }}</td>
                                        <td>{{ $data->tracking_id }}</td>
                                        <td>{{ $data->area }}</td>
                                        <td>{{ $data->category }}</td>
                                        <td>{{ $data->delivery_note }}</td>
                                        <td>{{ $data->collection }}</td>
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
