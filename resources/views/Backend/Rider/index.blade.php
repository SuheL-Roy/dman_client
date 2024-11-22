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
                                <h1 class="col-lg-5" style="padding:0px;">
                                    Agent Payment Collect <small>(Date Wise)</small>
                                </h1>


                                <form action="{{ route('order.report.rider.payment.report') }}" method="get">
                                    @csrf
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3" style="padding:0px;">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" name="fromdate" required value="{{ $fromdate }}"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2" style="padding:0px;">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm Primary">Load</button>
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
                                            <th data-field="rider_name" data-editable="false">Agent Name</th>
                                            <th data-field="create_by" data-editable="false">Create By</th>
                                            <th data-field="update_by" data-editable="false">Update By</th>
                                            <th data-field="t_collect" data-editable="false">Total Collect </th>
                                            <th data-field="actions" data-editable="false">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $key => $payment)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                                                <td>{{ $payment->invoice_id }}</td>
                                                <td>{{ $payment->agent->name }}</td>
                                                <td>{{ $payment->create->name ?? '' }}</td>
                                                <td>{{ $payment->updateby->name ?? 'Not yet' }}</td>
                                                <td>{{ $payment->t_collect }}</td>

                                                <td>
                                                    <a href="{{ route('agent.collect.show', $payment->id) }}"
                                                        class="btn btn-info btn-xs">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('agent.collect.agent.collected', $payment->id) }}"
                                                        class="btn btn-primary btn-xs">
                                                        <i class="fa fa-check"></i>
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
