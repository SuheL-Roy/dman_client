@extends('Master.main')
@section('title')
    Merchant Payment History Report (Date Wise)
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
                                Merchant Payment History Report <small>(Date Wise)</small>
                            </h1>
                            <form action="{{ route('order.report.merchant.payment.print') }}" 
                                    method="get" target="_blank"> @csrf
                                <input type="hidden" name="fromdate" value="{{ $fromdate }}"/>
                                <input type="hidden" name="todate" value="{{ $todate }}"/>
                                <button type="submit" class="btn btn-success btn-sm" style="float:right;">
                                    <i class="fa fa-print"></i>
                                </button>
                            </form>
                            <form action="{{ route('order.report.merchant.payment') }}" method="get">
                                @csrf
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3" style="padding:0px;">
                                            <label style="float:right;">From :</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="date" name="fromdate" required
                                                value="{{ $fromdate }}" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-2" style="padding:0px;">
                                            <label style="float:right;">To :</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="date" value="{{ $todate }}" 
                                                class="form-control" name="todate" required/>
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
                                        <th data-field="merchant" data-editable="false">Merchant</th>
                                        <th data-field="collection" data-editable="false">Collection</th>
                                        <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>
                                        <th data-field="return_charge" data-editable="false">Return Charge</th>
                                        <th data-field="amount" data-editable="false">Payable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($order as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->merchant }}</td>
                                        {{--  <td>{{ $data->tC }}</td>
                                        <td>{{ $data->tMp }}</td>
                                        <td>{{ $data->tRc }}</td>  --}}
                                        <td>{{ $data->collection }}</td>
                                        <td>{{ $data->merchant_pay }}</td>
                                        <td>{{ $data->return_charge }}</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align:right;">Total : &nbsp;</td>
                                        <td> &nbsp;&nbsp; {{ $tCol }}</td>
                                        <td> &nbsp;&nbsp; {{ $tMPay }}</td>
                                        <td> &nbsp;&nbsp; {{ $tRc }}</td>
                                        <td> &nbsp;&nbsp; {{ $tAmt }}</td>
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