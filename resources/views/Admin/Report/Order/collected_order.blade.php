@extends('Master.main')
@section('title')
    Order Report Collected
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
                                    Order Report <small>( Collected )</small>
                                </h1>

                                <form action="{{ route('order.report.collected') }}" method="GET">
                                    @csrf
                                    {{-- <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label style="float:right;">Status :</label>
                                            </div>
                                            <div class="col-lg-6">
                                                <select class="form-control" name="status">
                                                    <option> ---select status--- </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-3">
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
                                    <div class="col-lg-3">
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
                                            <th data-field="tracking_id" data-editable="false">Invoice ID</th>
                                            <th data-field="order_id" data-editable="false">Pickup Address</th>
                                            <th data-field="customer_name" data-editable="false">Delivery Address</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="type" data-editable="false">Type</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transfers as $key => $transfer)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $transfer->created_at->format('d-m-Y') }}</td>
                                                <td>{{ $transfer->invoice_id }}</td>
                                                <td>{{ $transfer->sender->address ?? '' }}</td>
                                                <td>{{ $transfer->receiver->address ?? '' }}</td>
                                                <td>{{ $transfer->status == 0 ? 'on the way' : 'complete' }}</td>
                                                <td>{{ $transfer->type }}</td>
                                                <td class="datatable-ct">

                                                    <a href="{{ route('delivery.assign.transfered.show', $transfer->id) }}"
                                                        class="btn btn-primary btn-xs">
                                                        <i class="fa fa-eye"></i>
                                                        view
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
