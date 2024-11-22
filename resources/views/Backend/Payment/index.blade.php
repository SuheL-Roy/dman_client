@extends('Master.main')
@section('title')
    Merchant Payment History
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <div class="col-lg-2" style="padding:0px; margin-right:20px;">
                                    <h1>Payment Confirmation</h1>
                                </div>


                            </div>
                            <form action="{{ route('merchant.advance.payment.print') }}" method="get" class="col-lg-1"
                                style="float:right;" target="_blank">
                                @csrf
                                <input type="hidden" name="merchant" value="{{ $selectedMerchant }}" />
                                <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                <input type="hidden" name="today" value="{{ $today }}" />
                                {{-- <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
                                <i class="fa fa-print"></i>
                            </button> --}}
                            </form>
                        </div>
                        <form action="{{ route('accounts.payment.complete') }}" method="post">

                            @csrf
                            <input type="hidden" name="merchant" value="" />
                            <input type="hidden" name="fromdate" value="" />
                            <input type="hidden" name="todate" value="" />
                            {{-- <button type="submit" class="btn btn-success btn-sm" style="float:right;"
                                onclick="return confirm('Are You Sure You Want To Confirm This Merchant Payment ??')">
                                Confirm
                            </button> --}}

                            <div class="clearfix"></div>
                            <hr>

                            <div class="sparkline13-graph">

                                <div class="datatable-dashv1-list custom-datatable-overright">
                                    <table id="table" data-toggle="table" data-pagination="false" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="date" data-editable="false">Date</th>
                                                <th data-field="invoice_id" data-editable="false">Invoice</th>
                                                {{-- <th data-field="total_order" data-editable="false">Total Order</th> --}}
                                                {{-- <th data-field="total_amount" data-editable="false">Total Amount</th> --}}
                                                <th data-field="create_by" data-editable="false">Create By</th>
                                                <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="payable" data-editable="false">Total Amount</th>
                                                <th data-field="avtion" data-editable="false">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payments as $key => $payment)
                                                <tr></tr>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $payment->updated_at->format('d-m-Y') }}</td>
                                                <td>{{ $payment->invoice_id }}</td>
                                                {{-- <td>wait</td> --}}
                                                {{-- <td>wait</td> --}}
                                                <td>{{ $payment->creator->name }}</td>
                                                <td>{{ $payment->status }}</td>
                                                <td>{{ $payment->t_payable }}</td>
                                                <td> 


                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        {{-- <a href="{{ route('merchent.pay.information.show', $payment->invoice_id) }}" class="btn btn-success">
                                                    <i class="fa fa-eye"></i> View
                                                </a> --}}
                                                        @if ($payment->status == 'Payment Paid By Fulfillment')
                                                            <a href="{{ route('merchent.pay.information.confirm', $payment->id) }}"
                                                                class="btn btn-info">
                                                                <i class="fa fa-check"></i> confirm
                                                            </a>
                                                        @endif

                                                        <a href="{{ route('merchent.pay.information.print', $payment->invoice_id) }}"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-print"></i> Print
                                                        </a>
                                                    </div>
                                                </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" style="text-align:right;">Total : &nbsp;</td>
                                                <td>&nbsp; {{ $tpay }}</td>
                                                <td></td>

                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            var selected_merchant_pay = 0;
            document.getElementById("selected_merchant_pay").innerHTML = 0;
            $(".select_id").change(function() {
                if ($(this).is(":checked")) {

                    var merchant_pay = $(this).closest('tr').find('.merchant_pay').html();
                    merchant_pay = parseFloat(merchant_pay);
                    selected_merchant_pay = selected_merchant_pay + merchant_pay;
                    document.getElementById("selected_merchant_pay").innerHTML = selected_merchant_pay;
                } else if ($(this).is(":not(:checked)")) {
                    var merchant_pay = $(this).closest('tr').find('.merchant_pay').html();
                    merchant_pay = parseFloat(merchant_pay);
                    selected_merchant_pay = selected_merchant_pay - merchant_pay;
                    document.getElementById("selected_merchant_pay").innerHTML = selected_merchant_pay;
                }
            });

            $(".selectall").click(function() {

                var checked = this.checked;
                if (checked == true) {
                    $('.select_id').prop('checked', true);
                    document.getElementById("selected_merchant_pay").innerHTML = totalmp;
                    selected_merchant_pay = totalmp;
                } else {
                    $('.select_id').prop('checked', false);
                    document.getElementById("selected_merchant_pay").innerHTML = 0;
                }
            });
        });
    </script>

{{-- // @if(!isset($tpay)) {
    //     {
    //         $tpay = 0
    //     }
    // }
    // @endif
    // var totalmp = "{{ $tpay }}";
    // totalmp = parseFloat(totalmp); --}}
@endsection
