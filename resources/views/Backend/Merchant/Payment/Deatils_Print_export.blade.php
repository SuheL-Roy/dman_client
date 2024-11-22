@extends('Master.main')
@section('title')
Merchant Payment Details Export
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
                                    Merchant Payment Details Export
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
                                <table id="table" data-toggle="table" data-pagination="true" data-search="true"
                                    data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            
                                            <th data-field="sl">SL.</th>
                                            <th data-field="create_date" data-editable="false">Date</th>
                                            <th data-field="invoice" data-editable="false">Tracking No</th>
                                            <th data-field="invoicaa" data-editable="false">Customer Name</th>
                                            <th data-field="werwe" data-editable="false"> Customer Phone</th>
                                            <th data-field="werwetwe" data-editable="false">Amount</th>
                                            <th data-field="creatorby" data-editable="false">Collect</th>
                                            <th data-field="update_by" data-editable="false">Delivery</th>
                                            <th data-field="rr" data-editable="false">COD</th>
                                            <th data-field="rr1" data-editable="false">Return</th>
                                            <th data-field="rr4" data-editable="false">Payble</th>
                                            <th data-field="rr2" data-editable="false">Status</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($merchantPayments as $key => $payment)
                                            <tr>
                                            
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{ $payment->created_at->format('d-m-Y') }} </td>
                                                <td> {{ $payment->tracking_id }} </td>
                                                <td> {{ Str::limit($payment->customer_name, 11) }} </td>
                                                <td> {{ $payment->customer_phone }} </td>
                                                <td> {{ $payment->colection }}</td>
                                                <td> {{ $payment->collect }}</td>
                                                <td> {{ $payment->delivery }}</td>
                                                <td> {{ $payment->cod }} </td>
                                                <td> {{ $payment->return_charge }}</td>
                                                <td> {{ $payment->collect - ($payment->delivery + $payment->cod + $payment->insurance + $payment->return_charge) }}
                                                </td>
                                                <td>{{ $payment->reason_status }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>


                                        <tr>
                                            <td colspan="5" style="text-align:right;">Total :
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $tCollection }}
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $tCollect }}
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $tDelivery }}
                                            </td>
                                            <td style="text-align: center;">
                                                {{ $tCod }}
                                            </td>
                                            <td style="text-align: center;">{{ $tReturnCharge }}</td>
                                            <td style="text-align: center;">{{ $tPayable }}</td>
                                            <td></td>
                                            <td></td>

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
