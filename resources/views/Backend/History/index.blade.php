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
                                <h1 class="col-lg-2" style="padding:0px; margin-right:20px;">
                                    Merchant Payment History
                                </h1>

                                <form action="{{ route('merchent.pay.information.load') }}" method="POST">
                                    @csrf
                                    <div class="col-lg-4">
                                        <div class="row">


                                            @can('superAdmin')
                                                <div class="col-lg-6">
                                                    <select name="merchant" class="selectpicker form-control"
                                                        title="Select Merchant" data-style="btn-info" data-live-search="true">
                                                        {{--  <option value="">Select Merchant</option>  --}}
                                                        @foreach ($user as $data)
                                                            <option value="{{ $data->user_id }}">{{ $data->business_name }} -
                                                                (M{{ $data->id }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endcan

                                            <div class="col-lg-6">
                                                <select name="status" class="form-control" required
                                                    oninvalid="this.setCustomValidity('Please select status')"
                                                    oninput="setCustomValidity('')">
                                                    <option value="" selected>select status</option>
                                                    <option value="Payment Received By Merchant"
                                                        {{ $orderStatus === 'Payment Received By Merchant' ? 'selected' : '' }}>
                                                        Payment Completed
                                                    </option>
                                                    <option value="Payment Processing"
                                                        {{ $orderStatus === 'Payment Processing' ? 'selected' : '' }}>
                                                        Payment Processing
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row">
                                            <div class="col-lg-3" style="padding:0px;">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                    class="form-control"
                                                    class="@error('fromdate') border:1px solid red @enderror" />
                                            </div>
                                            @error('fromdate')
                                                <span style="color: red" class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="row">
                                            <div class="col-lg-2" style="padding:0px;">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" value="{{ $today }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit"class="btn btn-primary btn-sm Primary">Load</button>
                                </form>
                            </div>
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

                                                @cannot('activeMerchant')
                                                    <th data-field="merchant_name" data-editable="false">Merchant Name</th>
                                                @endcannot

                                                {{-- <th data-field="total_order" data-editable="false">Total Order</th>
                                                <th data-field="total_amount" data-editable="false">Total Amount</th> --}}
                                                <th data-field="create_by" data-editable="false">Update By</th>
                                                <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="payable" data-editable="false">Total Amount</th>
                                                <th data-field="avtion" data-editable="false">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($payments as $key => $payment)
                                                <tr></tr>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $payment->updated_at->format('d-m-Y') }}</td>
                                                <td>{{ $payment->invoice_id }}</td>

                                                @cannot('activeMerchant')
                                                    <td>{{ $payment->business_name }}</td>
                                                @endcannot

                                                {{-- <td>{{$payment->id}}</td>
                                                <td>wait</td> --}}
                                                <td>{{ $payment->update_data->name }}</td>
                                                <td>{{ $payment->status }}</td>
                                                <td>{{ $payment->t_payable }}</td>
                                                @php
                                                    $total = $total + $payment->t_payable;
                                                @endphp
                                                <td>
                                                    {{-- <a href="{{ route('merchent.pay.information.show',['invoice_id'=>$payment->invoice_id]) }}"
                                                        class="btn "> 
                                                        <button  class="btn btn-info" type="button" ><i class="fa fa-eye"></i> View  </button>


                                                    </a> --}}
                                                    <a class="btn btn-warning"
                                                        href="{{ route('merchent.pay.information.export_details_print', ['invoice_id' => $payment->invoice_id]) }}"
                                                        target="_blank">
                                                        View
                                                    </a>
                                                    <a href="{{ route('merchent.pay.information.print', ['invoice_id' => $payment->invoice_id]) }}"
                                                      target="_blank"  class="btn ">
                                                        <button class="btn btn-success" type="button"><i
                                                                class="fa fa-print"></i> Print </button>

                                                    </a>
                                                </td>

                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="5">
                                                    <span style="float:right;">Total:</span>
                                                </td>
                                                <td colspan="3">
                                                    <span style="">{{ $total }} </span>
                                                </td>

                                            </tr>
                                        </tbody>
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
            @if (!isset($tpay))
                {{ $tpay = 0 }}
            @endif
            var totalmp = "{{ $tpay }}";
            totalmp = parseFloat(totalmp);
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
@endsection
