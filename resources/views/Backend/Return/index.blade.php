@extends('Master.main')
@section('title')
    Rider Return Payment
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
                                    Rider Return Payment
                                </h1>
                                <form action="{{ route('order.report.admin.rider.return.info') }}" method="get">
                                    @csrf
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="date" name="fromdate" required value="{{ $fromdate }}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-7">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                            <button type="submit"class="btn btn-success btn-sm">Load</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="{{ route('order.report.rider.payment.report.print') }}" method="get"
                                    class="col-lg -1" style="float:right;" target="_blank">
                                    <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                    <input type="hidden" name="todate" value="{{ $todate }}" />
                                    <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="create_date" data-editable="false">Create Date</th>
                                            <th data-field="invoice" data-editable="false">Invoice No</th>
                                            <th data-field="invoice" data-editable="false">M.Name</th>
                                            <th data-field="sfesr" data-editable="false">S.Name</th>
                                            <th data-field="werwe" data-editable="false">S.Phone</th>
                                            <th data-field="werwetwe" data-editable="false">S.Address</th>
                                            <th data-field="rider_name" data-editable="false">Rider Name</th>
                                            <th data-field="create_by" data-editable="false">Create By</th>
                                            <th data-field="update_by" data-editable="false">Update By</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="actions" data-editable="false">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($payments as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->created_at }}</td>
                                                <td>{{ $data->invoice_id }}</td>
                                                <td>{{ $data->merchant->name }}</td>
                                                <td>{{ $data->shop_name }}</td>
                                                <td>{{ $data->shop_phone }}</td>
                                                <td>{{ $data->shop_address }}</td>
                                                <td>{{ $data->rider->name ?? '' }}</td>
                                                <td>{{ $data->creator->name }}</td>
                                                <td>{{ $data->updator->name ?? 'Not Yet' }}</td>
                                                <td>{{ $data->status === 'Assigned Rider For Return' ? 'ARFR' : '' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('order.report.admin.rider.return.show', $data->id) }}"
                                                        class="btn btn-info btn-xs">
                                                        <i class="fa fa-eye"></i>
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
