@extends('Master.main')
@section('title')
    Merchant Payment
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">



                        <div class="sparkline13-graph">

                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <table id="table" data-toggle="table" data-pagination="false" data-search="true"
                                    data-show-columns="false" data-show-pagination-switch="false" data-show-refresh="false"
                                    data-key-events="false" data-show-toggle="false" data-resizable="false"
                                    data-cookie="false" data-cookie-id-table="saveId" data-show-export="false"
                                    data-click-to-select="false" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="date" data-editable="false">Date</th>
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            <th data-field="m_name" data-editable="false">M. Name</th>
                                            <th data-field="s_name" data-editable="false">S. Name</th>
                                            <th data-field="s_phone" data-editable="false">S. Phone</th>
                                            <th data-field="collection" data-editable="false">Collected</th>
                                            <th data-field="delivery" data-editable="false">Delivery</th>
                                            <th data-field="cod" data-editable="false">COD</th>
                                            <th data-field="ins" data-editable="false">INS</th>
                                            <th data-field="return_charge" data-editable="false">Return Charge</th>
                                            <th data-field="payable" data-editable="false">Payable</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($merchantPayments as $key => $payment)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $payment->created_at->format('d-m-Y') }} </td>
                                                <td> {{ $payment->tracking_id }} </td>
                                                <td> {{ $payment->merchant }} </td>
                                                <td> {{ $payment->shop }} </td>
                                                <td> {{ $payment->shop_phone }} </td>
                                                <td> {{ $payment->collect }}</td>
                                                <td> {{ $payment->delivery }}</td>
                                                <td> {{ $payment->cod }} </td>
                                                <td> {{ $payment->insurance }} </td>
                                                <td> {{ $payment->return_charge }}</td>
                                                <td> {{ $payment->collect - ($payment->delivery + $payment->cod + $payment->insurance + $payment->return_charge) }}
                                                </td>
                                            </tr>
                                        @endforeach --}}

                                    </tbody>
                                </table>
                            </div>
                        </div>
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