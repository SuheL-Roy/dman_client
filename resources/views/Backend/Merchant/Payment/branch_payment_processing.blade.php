@extends('Master.main')
@section('title')
    Branch Payment Processing
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
                                    Branch Payment Processing
                                </h1>
                                {{-- <form action="{{ route('order.report.admin.rider.return.info') }}" method="get">
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
                                </form> --}}
                                {{-- <form action="{{ route('order.report.rider.payment.report.print') }}" method="get"
                                    class="col-lg -1" style="float:right;" target="_blank">
                                    <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                    <input type="hidden" name="todate" value="{{ $todate }}" />
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
                                            <th data-field="create_date" data-editable="false">Invoice Date(Form-To)</th>
                                            <th data-field="invoice" data-editable="false">Invoice No</th>
                                            <th data-field="werwe" data-editable="false">Branch Name</th>
                                            <th data-field="update_by" data-editable="false">Total pickup commission</th>
                                            <th data-field="rr" data-editable="false">Total Delivery commission</th>
                                            <th data-field="rc" data-editable="false">Total return commission takbe</th>
                                            <th data-field="actions" data-editable="false">Action </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $paymentinfo)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $paymentinfo->form_date }} - {{ $paymentinfo->todate }}</td>
                                                <td>{{ $paymentinfo->invoice_id }}</td>
                                                <td>{{ $paymentinfo->area ?? '' }}</td>
                                                <td>{{ $paymentinfo->t_pickup_commission_charge ?? '' }}</td>
                                                <td>{{ $paymentinfo->t_delivery_charge }}</td>
                                                <td>{{ $paymentinfo->t_return_commission_charge }}</td>


                                                <td>

                                                    <div class="btn-group" role="group" aria-label="Basic example">

                                                        <a class="btn btn-success"
                                                            href="{{ route('branch.payment.collect.print', ['invoice_id' => $paymentinfo->invoice_id]) }}"
                                                            target="_blank">
                                                            Print
                                                        </a>


                                                        @if ($paymentinfo->status == 1)
                                                            <a onclick="return confirm('Are You Sure You Want To Payment Confirm ??')"
                                                                href="{{ route('merchant.payment.collect.conform', ['id' => $paymentinfo->invoice_id]) }}"
                                                                class="btn btn-primary">
                                                                <i class="fa fa-money"></i>
                                                                pay confirm
                                                            </a>
                                                        @endif
                                                    </div>


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
