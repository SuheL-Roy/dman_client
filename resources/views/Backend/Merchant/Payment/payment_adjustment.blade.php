@extends('Master.main')
@section('title')
    Payment Adjustment
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1 class="col-lg-2" style="padding:0px; margin-right:20px;">
                                        Payment Adjustment
                                        <br>
                                    </h1>

                                    <form action="{{ route('merchant.payment.adjustment') }}" method="GET">
                                        @csrf
                                        <div class="col-lg-3">
                                            <div class="row">

                                                <div class="col-lg-7">
                                                    <select name="business_name" title="Merchant" class="form-control"
                                                        required>
                                                        <option> ---Select Merchant--- </option>
                                                        @foreach ($merchants as $merchant)
                                                            <option value="{{ $merchant->business_name }}"
                                                                {{ $selectedMerchant == $merchant->business_name ? 'selected' : '' }}>
                                                                {{ $merchant->business_name }}
                                                            </option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
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
                                        <div class="col-lg-3">
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


                                    <form action="{{ route('merchant.payment.adjustment.print') }}" method="get"
                                        class="col-lg-1" style="float:right;" target="_blank">
                                        @csrf
                                        <input type="hidden" name="business_name" value="{{ $selectedMerchant }}" />
                                        <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                        <input type="hidden" name="today" value="{{ $today }}" />
                                        <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
                                            <i class="fa fa-print"></i>
                                        </button>
                                    </form>
                                </div>
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
                                            <th data-field="invoice" data-editable="false">Invoice No</th>
                                            <th data-field="business_name" data-editable="false">Business Name</th>
                                            <th data-field="m_name" data-editable="false">M. Name</th>
                                            <th data-field="m_phone" data-editable="false">M. Phone</th>
                                            <th data-field="m_areaxcfgnhdfjlkgn" data-editable="false">M. Address</th>
                                            <th data-field="m_addressjhggguyguy" data-editable="false">M. Area</th>
                                            <th data-field="paid_amount" data-editable="false">Paid Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $key => $paymentinfo)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}.</td>
                                                <td>{{ $paymentinfo->invoice_id }}.</td>
                                                <td>{{ $paymentinfo->business_name }}.</td>
                                                <td>{{ $paymentinfo->name }}</td>
                                                <td>{{ $paymentinfo->mobile }}</td>
                                                <td>{{ $paymentinfo->address }}</td>
                                                <td>{{ $paymentinfo->area }}</td>
                                                <td>{{ $paymentinfo->p_amount }}</td>
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
