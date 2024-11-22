@extends('Master.main')
@section('title')
    Invoice Processing
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
                                    Invoice Processing
                                </h1>

                                <form action="{{ route('accounts.merchant.payment') }}" method="get">
                                    @csrf
                                    <div class="col-lg-2" style="padding:0px;">

                                        <select name="merchant" class="selectpicker form-control" title="Select Merchant"
                                            data-style="btn-info" data-live-search="true" required>
                                            {{--  <option value="">Select Merchant</option>  --}}
                                            {{-- {{ $area == $value->zone_name ? 'selected' : '' }} --}}
                                            @foreach ($merchants as $merChant)
                                                <option value="{{ $merChant->user_id }}"
                                                    {{ $merchant == $merChant->user_id ? 'selected' : '' }}>
                                                    {{ $merChant->business_name }}
                                                    -
                                                    (M{{ $merChant->id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                    <button type="submit"class="btn btn-primary btn-sm Primary">Load</button>
                                </form>
                            </div>
                        </div>
                        <form action="{{ route('accounts.payment.complete') }}" method="post">
                            {{--  target="_blank">   --}}
                            @csrf
                            <input type="hidden" name="merchant" value="{{ $merchant }}" />
                            <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                            <input type="hidden" name="todate" value="{{ $todate }}" />
                            <button type="submit" class="btn btn-success btn-sm" style="float:right;"
                                onclick="return confirm('Are You Sure You Want To Confirm This Merchant Payment ??')">
                                Confirm
                            </button>

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
                                    <table id="table" data-toggle="table" data-pagination="false" data-search="true"
                                        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="selectall" /></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="date" data-editable="false"style="text-align:center;">Date
                                                </th>
                                                <th data-field="tracking_id"
                                                    data-editable="false"style="text-align:center;">Tracking ID</th>
                                                <th data-field="m_name" data-editable="false"style="text-align:center;">
                                                    Customer Name</th>
                                                <th data-field="s_phone" data-editable="false"style="text-align:center;">
                                                    Customer Phone</th>
                                                <th data-field="s_name" data-editable="false"style="text-align:center;">
                                                    Customer Address</th>
                                                <th data-field="collection" data-editable="false"style="text-align:center;">
                                                    Invoice Value</th>
                                                <th data-field="collect" data-editable="false"style="text-align:center;">
                                                    Collect</th>
                                                <th data-field="delivery" data-editable="false"style="text-align:center;">
                                                    Delivery</th>
                                                <th data-field="cod" data-editable="false"style="text-align:center;">COD
                                                </th>
                                                {{--   <th data-field="ins" data-editable="false"style="text-align:center;">INS</th> --}}
                                                <th data-field="return_charge"
                                                    data-editable="false"style="text-align:center;">Return Charge</th>
                                                <th data-field="payable" data-editable="false"style="text-align:center;">
                                                    Payable</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($complete as $data)
                                                <tr>
                                                    <td style="text-align:center;">&nbsp &nbsp<input type="checkbox"
                                                            class="select_id" value="{{ $data->tracking_id }}"
                                                            name="tracking_ids[]" />
                                                    </td>
                                                    <td style="text-align:center;">{{ $i++ }}.</td>
                                                    <td style="text-align:center;">
                                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->order_create_date)->format('d-m-Y') }}
                                                    </td>
                                                    <td style="text-align:center;">{{ $data->tracking_id }}</td>
                                                    <td style="text-align:center;">{{ $data->customer_name }}</td>
                                                    <td style="text-align:center;">{{ $data->customer_phone }}</td>
                                                    <td style="text-align:center;">{{ $data->customer_address }}</td>
                                                    <td style="text-align:center;">{{ $data->colection }}</td>
                                                    <td style="text-align:center;">{{ $data->collect }}</td>
                                                    <td style="text-align:center;">{{ $data->delivery }}</td>
                                                    <td style="text-align:center;">{{ $data->cod }}</td>
                                                    {{--  <td>{{ $data->insurance }}</td> --}}
                                                    <td style="text-align:center;">{{ $data->return_charge }} </td>
                                                    {{--                                                 
                                                @if ($data->collect == 0)
                                                    
                                                @else
                                                    
                                                @endif --}}
                                                    <td style="text-align:center;" class="merchant_pay">
                                                        {{ $data->collect - ($data->delivery + $data->cod + $data->insurance + $data->return_charge) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            {{-- @foreach ($return as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->date }}</td>
                                                <td>{{ $data->tracking_id }}</td>
                                                <td>{{ $data->order_id }}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $data->return_charge }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach --}}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" style="text-align:right;">Total : &nbsp;</td>
                                                {{--  <td> &nbsp;&nbsp; {{ $tCol }}</td>  --}}
                                                <td> &nbsp;&nbsp; {{ $tcollect }}</td>
                                                <td> &nbsp;&nbsp; {{ $tdelivery }}</td>
                                                <td> &nbsp;&nbsp; {{ $tcod }}</td>
                                                {{--   <td> &nbsp;&nbsp; {{ $tinsurance }}</td> --}}
                                                <td> &nbsp;&nbsp; {{ $treturn }}</td>
                                                <td>{{ $tpay }}</td>
                                            </tr>
                                            @if (isset($tCol))
                                                <tr>
                                                    <td colspan="5"> </td>
                                                    <td><b>Selected Merchant Pay(Total):</b></td>
                                                    <td><b id="selected_merchant_pay"></b> </td>
                                                    {{-- <td><b> &nbsp;&nbsp; {{ $tCol }}</b></td> --}}

                                                    <td colspan="6"> </td>

                                                </tr>
                                            @endif
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
                    if ($('.select_id:checked').length === 0) {
                        window.location.reload(); // Reload the page
                    }
                    document.getElementById("selected_merchant_pay").innerHTML = 0;
                }
            });
        });
    </script>
@endsection
