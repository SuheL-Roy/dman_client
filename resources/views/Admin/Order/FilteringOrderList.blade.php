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
                                <h1 class="col-lg-4" style="padding:0px;">Order Filtering</h1>
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
                                            <th data-field="Pickup_date" data-editable="false">Pickup Date</th>
                                            {{-- <th data-field="pickup_time" data-editable="false">Pickup Time</th> --}}
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            <th data-field="s_name" data-editable="false">Merchant Name</th>
                                            <th data-field="ee" data-editable="false">Business Name</th>
                                            <th data-field="eewwq" data-editable="false">Merchant Phone</th>
                                            <th data-field="shopwe_name" data-editable="false">Merchant Address</th>
                                            <th data-field="customer_name" data-editable="false">Customer Name</th>
                                            <th data-field="customer_phone" data-editable="false">Customer Phone</th>
                                            <th data-field="destination" data-editable="false">Destination</th>
                                            <th data-field="customer_address" data-editable="false">Customer Address</th>
                                            <th data-field="collection" data-editable="false">Invoice Value</th>
                                            <th data-field="merchant_pay" data-editable="false">Collected Amount</th>
                                            {{-- <th data-field="pickup_time" data-editable="false">Delivery Date</th> --}}
                                            <th data-field="type" data-editable="false">Type</th>
                                            <th data-field="note" data-editable="false">Remarks</th>
                                            <th data-field="status" data-editable="false">Status</th>

                                            {{-- <th data-field="action">Action</th> --}}


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            <tr>
                                                <td></td>
                                                @if ($data->status == 'Order Placed')
                                                    <td>{{ $i++ }}.</td>
                                                    {{-- <td>{{ $data->tracking_id }}</td> --}}
                                                    <td><b>{{ $data->pickup_date }}</b></td>
                                                    {{-- <td><b>{{ $data->pickup_time }}</b></td> --}}
                                                    <td><a href="{{ route('order.view', ['id' => $data->tracking_id]) }}"
                                                            target="_blank"><b
                                                                style="color: var(--primary)">{{ $data->tracking_id }}</b></a>
                                                    </td>

                                                    <td><b>{{ $data->name }}</b></td>
                                                    <td><b>{{ $data->business_name }}</b></td>
                                                    <td><b>{{ $data->mobile }}</b></td>
                                                    <td><b>{{ $data->address }}</b></td>

                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->area }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>{{ $data->collection }}</td>
                                                    <td>{{ $data->collect }}</td>
                                                    <td>{{ $data->type == 'Urgent' ? 'One Hour' : 'Regular' }}</td>
                                                    <td><b>{{ $data->remarks }} | {{ $data->delivery_note }}</b>
                                                    </td>
                                                    <td>{{ $data->status }}</td>
                                                @else
                                                    <td>{{ $i++ }}.</td>
                                                    {{-- <td>{{ $data->tracking_id }}</td> --}}
                                                    <td><b>{{ $data->pickup_date }}</b></td>
                                                    <td><b>{{ $data->pickup_time }}</b></td>
                                                    <td><a href="{{ route('order.view', ['id' => $data->tracking_id]) }}"
                                                            target="_blank"><b
                                                                style="color: var(--primary)">{{ $data->tracking_id }}</b></a>
                                                    </td>

                                                    <td><b>{{ $data->name }}</b></td>
                                                    <td><b>{{ $data->business_name }}</b></td>
                                                    <td><b>{{ $data->mobile }}</b></td>
                                                    <td><b>{{ $data->address }}</b></td>

                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->area }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>{{ $data->collection }}</td>
                                                    <td>{{ $data->collect }}</td>
                                                    <td>{{ $data->type == 'Urgent' ? 'One Hour' : 'Regular' }}</td>
                                                    <td><b>{{ $data->remarks }} | {{ $data->delivery_note }}</b>
                                                    </td>
                                                    <td>{{ $data->status }}</td>
                                                @endif
                                                {{-- <td class="datatable-ct">
                                                    <div class="btn-group" role="group" aria-label="Basic example">

                                                        @can('superAdmin')
                                                            <a class="btn btn-info"
                                                                href="{{ route('order.confirm_edit', ['id' => $data->tracking_id]) }}"
                                                                class="btn ">

                                                                <i class="fa fa-edit"></i> Edit

                                                            </a>
                                                            <a class="btn btn-success"
                                                                href="{{ route('order.collect.print', ['id' => $data->tracking_id]) }}"
                                                                class="btn" target="_blank">

                                                                <i class="fa fa-print"></i> Print

                                                            </a>
                                                            <a href="{{ route('request.assign.delete.order.admin', ['id' => $data->tracking_id]) }}"
                                                                class="btn btn-danger"
                                                                onclick="return confirm('Are You Sure You Want To Cancel This ??')"
                                                                title="PickUp Delete ??">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                        @endcan

                                                        @if ($data->status == 'Order Placed' || $data->status == 'Assigned Pickup Rider')
                                                            <a href="{{ route('request.assign.cancel', ['id' => $data->tracking_id]) }}"
                                                                class="btn btn-warning  "
                                                                onclick="return confirm('Are You Sure You Want To Cancel This ??')"
                                                                title="PickUp Cancel ??">
                                                                <i class="fa fa-close"></i> Cancel
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td> --}}

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
