@extends('Master.main')
@section('title')
    Confirmed Order List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Confirmed Order List</h1>
                                <div class="container col-lg-8">
                                    <form action="" method="post">
                                        @csrf
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-lg-4" style="padding-right:5px;">
                                                    <label style="float:right;">From :</label>
                                                </div>
                                                <div class="col-lg-8" style="padding-left:5px;">
                                                    <input type="date" name="fromdate" value="{{ $fromdate ?? '' }}"
                                                        required class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-lg-2" style="padding-right:5px;">
                                                    <label style="float:right;">To :</label>
                                                </div>
                                                <div class="col-lg-8" style="padding-left:5px;">
                                                    <input type="date" class="form-control" name="todate"
                                                        @if (isset($todate)) value="{{ $todate }}"
                                                        @else
                                                        value="{{ date('Y-m-d') }}" @endif
                                                        required />
                                                </div>

                                            </div>
                                        </div>
                                        <button type="submit" class="col-lg-2 btn btn-success btn-sm">
                                            Load
                                        </button>
                                    </form>
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
                                            {{-- <th data-field="Pickup_date" data-editable="false">Date</th> --}}
                                            <th data-field="pickup_time" data-editable="false">Pickup Time</th>
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            <th data-field="Order_ID" data-editable="false">Order ID</th>
                                            {{-- <th data-field="s_name" data-editable="false">Merchant Name</th>
                                            <th data-field="ee" data-editable="false">Business Name</th>
                                            <th data-field="eewwq" data-editable="false">Merchant Phone</th>
                                            <th data-field="shopwe_name" data-editable="false">Merchant Address</th>  --}}
                                            <th data-field="customer_name" data-editable="false">Customer Name</th>
                                            <th data-field="customer_phone" data-editable="false">Customer Phone</th>
                                            <th data-field="destination" data-editable="false">Destination</th>
                                            <th data-field="customer_address" data-editable="false">Customer Address</th>
                                            <th data-field="collection" data-editable="false">Invoice Value</th>
                                            <th data-field="merchant_pay" data-editable="false">Collected Amount</th>
                                            {{-- <th data-field="pickup_time" data-editable="false">Delivery Date</th> --}}
                                            <th data-field="type" data-editable="false">Type</th>
                                           {{-- <th data-field="s_code" data-editable="false">Security Code</th>
                                            <th data-field="r_code" data-editable="false">Return Code</th> --}}
                                            <th data-field="note" data-editable="false">Remarks</th>
                                            <th data-field="status" data-editable="false">Status</th>

                                          {{--  <th data-field="action">Action</th>  --}}


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td></td>

                                                @if ($data->status == 'Order Placed')
                                                    <td><b>{{ $i++ }}.</b></td>
                                                    {{-- <td><b>{{ $data->pickup_date }}</b></td> --}}
                                                    <td><b>{{ $data->pickup_time }}</b></td>
                                                    <td>
                                                        <a href="{{ route('order.view', ['id' => $data->tracking_id]) }}"
                                                            target="_blank"><b
                                                                style="color: var(--primary)">{{ $data->tracking_id }}</b></a>
                                                    </td>
                                                    <td><b>{{ $data->order_id }}</b></td>
                                                  {{--  <td><b>{{ $data->name }}</b></td> 
                                                    <td><b>{{ $data->business_name }}</b></td>
                                                    <td><b>{{ $data->mobile }}</b></td>
                                                    <td><b>{{ $data->address }}</b></td> --}}

                                                    <td><b>{{ $data->customer_name }}</b></td>
                                                    <td><b>{{ $data->customer_phone }}</b></td>
                                                    <td><b>{{ $data->area }}</b></td>
                                                    <td><b>{{ $data->customer_address }}</b></td>
                                                    <td><b>{{ $data->collection }}</b></td>
                                                    <td><b>{{ $data->collect }}</b></td>
                                                    <td><b>{{ $data->type == 'Urgent' ? 'One Hour' : $data->type }}</b>
                                                 {{--   <td><b>{{ $data->security_code }}</b></td>
                                                    <td><b>{{ $data->return_code }}</b></td> --}}
                                                    <td><b>{{ $data->remarks }} | {{ $data->delivery_note }}</b>
                                                    </td>
                                                    <td><b>{{ $data->status }}</b></td>
                                                    </td>
                                                @else
                                                    <td>{{ $i++ }}.</td>
                                                    {{-- <td>{{ $data->tracking_id }}</td> --}}
                                                    {{-- <td><b>{{ $data->pickup_date }}</b></td> --}}
                                                    <td><b>{{ $data->pickup_time }}</b></td>
                                                    <td><a href="{{ route('order.view', ['id' => $data->tracking_id]) }}"
                                                            target="_blank"><b
                                                                style="color: var(--primary)">{{ $data->tracking_id }}</b></a>
                                                    </td>
                                                     <td><b>{{ $data->order_id }}</b></td>
                                                   {{-- <td><b>{{ $data->name }}</b></td>
                                                    <td><b>{{ $data->business_name }}</b></td>
                                                    <td><b>{{ $data->mobile }}</b></td>
                                                    <td><b>{{ $data->address }}</b></td> --}}

                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->area }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>{{ $data->collection }}</td>
                                                    <td>{{ $data->collect }}</td>
                                                    <td>{{ $data->type == 'Urgent' ? 'One Hour' : 'Regular' }}</td>
                                                    {{-- <td><b>{{ $data->security_code }}</b></td>
                                                    <td><b>{{ $data->return_code }}</b></td> --}}
                                                    <td><b>{{ $data->remarks }} | {{ $data->delivery_note }}</b>
                                                    </td>

                                                    <td>{{ $data->status }}</td>
                                                @endif
                                               

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

