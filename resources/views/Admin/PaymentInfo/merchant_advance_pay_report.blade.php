<?php
use Illuminate\Support\Str;
use App\User;
?>

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
                        <form action="{{ route('accounts.save.advance.payment') }}" method="POST">
                            @csrf
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1 class="col-lg-2" style="padding:0px; ">
                                        Advance Payment
                                    </h1>
                                    <div class="container col-lg-10">
                                        @if (session('success'))
                                            <div class="alert alert-dismissible alert-success">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ session('success') }}</strong>
                                            </div>
                                        @elseif(session('message'))
                                            <div class="alert alert-dismissible alert-info">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ session('message') }}</strong>
                                            </div>
                                        @elseif(session('danger'))
                                            <div class="alert alert-dismissible alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ session('danger') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <br><br><br>
                                <div class="main-sparkline13-hd">
                                    <div class="col-lg-3">
                                        <select name="merchant_id" id="merchant" class="form-control"
                                            title="Select Merchant" data-style="btn-info" data-live-search="true" required
                                            style="display: block;">
                                            <option>Select Merchant</option>
                                            @foreach ($merchants as $merchant)
                                                <option value="{{ $merchant->id }}">{{ $merchant->business_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label style="float:right;">Business:</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" id="business" name="business" required value=""
                                                    class="form-control" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label style="float:right;">Area:</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" value="" class="form-control" id="area"
                                                    name="area" readonly required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label>Phone:</label>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" value="" class="form-control" id="phone"
                                                    name="phone" readonly required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <hr><br>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="float:right;">Amount*:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="number" value="" class="form-control" name="amount" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label style="float:right;">Comment:</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" value="" class="form-control" name="comment" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-center">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                        </form>
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
                                    data-key-events="true" data-show-toggle="true" data-resizable="true"
                                    data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                    data-click-to-select="true" data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            {{-- <th data-field="merchant_id" data-editable="false">Merchant ID</th> --}}
                                            <th data-field="business" data-editable="false">Business</th>
                                            <th data-field="area" data-editable="false">Area</th>
                                            <th data-field="phone" data-editable="false">Phone</th>
                                            <th data-field="amount" data-editable="false">Amount</th>
                                            <th data-field="comment" data-editable="false">Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($advancePayments as $key => $advancePayment)
                                            <tr>
                                                <td></td>
                                                <td>{{ $key + 1 }}</td>
                                                {{-- 
                                                <td>{{ $name }}</td> --}}
                                                <td>{{ $advancePayment->business }}</td>
                                                <td>{{ $advancePayment->area }}</td>
                                                <td>{{ $advancePayment->phone }}</td>
                                                <td>{{ $advancePayment->amount }}</td>
                                                <td>{{ Str::limit($advancePayment->comment, 50) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="text-align:right;">Total : &nbsp;</td>
                                            {{--  <td> &nbsp;&nbsp;</td>  --}}
                                            <td> &nbsp;&nbsp; </td>
                                            <td> &nbsp;&nbsp; </td>
                                            <td> &nbsp;&nbsp; </td>
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


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });

    $(document).ready(function() {
        $('#merchant').change(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var merchant = $('#merchant').val();

            $.ajax({
                type: "POST",
                url: "{{ route('accounts.merchant.getMerchant') }}",
                data: {
                    merchant: merchant,
                },
                success: function(response) {
                    console.log(response.merchantInfo);
                    var area = $("#area").val('');
                    var mobile = $("#phone").val('');
                    var business = $("#business").val('');

                    area.val(response.merchantInfo.area);
                    mobile.val(response.merchantInfo.mobile);
                    business.val(response.merchantInfo.business_name);
                },
                error: function(response) {}
            });
        });
    });
</script>
