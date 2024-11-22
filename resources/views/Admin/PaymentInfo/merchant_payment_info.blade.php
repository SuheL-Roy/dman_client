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
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-3" style="padding:0px; margin-right:20px;">
                                    Payment Information
                                </h1>
                                <div class="col-lg-6">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-info text-center"
                                            style="padding-top:5px; padding-bottom:5px; margin-top:0px; margin-bottom:0px;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>





                            </div>
                        </div>





                        <div class="clearfix"></div>

                        {{--    Update data --}}

                        <div id="InformationproModalhdbgcl"
                            class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('accounts.merchant.paymentinfo.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title">
                                                Edit <small style="color:white;">( Payment Information )</small>
                                            </h4>
                                            <div class="modal-close-area modal-close-df">
                                                <a class="close" data-dismiss="modal" href="#">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="modal-body" style="padding-top:20px; padding-bottom:0px;">
                                            <input name="id" class="id" type="hidden" />
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Bank Name <span class="table-project-n"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="bankname"
                                                            class="bankname form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Account No. <span class="table-project-n"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="accountno"
                                                            class="accountno form-control" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Payment Type <span class="table-project-n"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select name="bkash_account_type" class="bkashaccount form-control">
                                                            = <option value="Bank">Bank</option>
                                                            <option value="Bkash">Bkash</option>
                                                            <option value="Nagad">Nagad</option>
                                                            <option value="Rocket">Rocket</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Account Type <span class="table-project-n"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <select name="bkash_account_type" class="bkashaccount form-control">
                                                            = <option value="Agent">Agent</option>
                                                            <option value="Personal">Personal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Mobile No. <span class="table-project-n"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                        <input type="text" name="bkashno" class="bkashno form-control" />
                                                    </div>
                                                </div>
                                            </div>






                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
                                            <button class="btn btn-success btn-sm" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




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
                                            <th data-field="sl">SL.</th>
                                            <th data-field="name" data-editable="false">Merchant Name</th>
                                            <th data-field="bank_name" data-editable="false">Bank Name</th>
                                            <th data-field="branch_name" data-editable="false">Hub Name</th>
                                            <th data-field="account_holder_name" data-editable="false">Account Holder Name
                                            </th>
                                            <th data-field="account_type" data-editable="false">Account Type</th>
                                            <th data-field="account_no" data-editable="false">Account No.</th>
                                            <th data-field="routing_no" data-editable="false">Routing No.</th>
                                            <th data-field="payment_type" data-editable="false">Payment Type</th>
                                            <th data-field="mobile_account_type" data-editable="false">Account Type</th>
                                            <th data-field="mobile_no" data-editable="false">Mobile No.</th>
                                            @if (auth()->user()->role == 1)
                                                <th data-field="action" data-editable="false">Action</th>
                                            @endif


                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($data as $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->bankname }}</td>
                                                <td>{{ $value->branchname }}</td>
                                                <td>{{ $value->accountholdername }}</td>
                                                <td>{{ $value->accounttype }}</td>
                                                <td>{{ $value->accountno }}</td>
                                                <td>{{ $value->routingnumber }}</td>
                                                <td>{{ $value->mb_name }}</td>
                                                <td>{{ $value->mb_type }}</td>
                                                <td>{{ $value->mb_number }}</td>

                                                @if (auth()->user()->role == 1)
                                                    <td class="datatable-ct">

                                                        <a href="{{ route('accounts.merchant.paymentinfo.edit', ['id' => $value->id]) }}"
                                                            class="btn btn-primary btn-xs">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
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
            $('.ediT').on('click', function() {

                var id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('accounts.merchant.paymentinfo.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.bankname').val(data[0]['bankname']);
                        $('.accountno').val(data[0]['accountno']);
                        $(".bkashaccount").val(data[0]['bkashaccount']);
                        $('.bkashno').val(data[0]['bkashno']);

                    }
                });
            });



            $('#updatE').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('accounts.merchant.paymentinfo.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".id").val(),
                        'bankname': $(".bankname").val(),
                        'accountno': $(".accountno").val(),
                        'bkashaccount': $(".bkashaccount").val(),
                        'bkashno': $(".bkashno").val(),


                    },
                    success: function() {
                        $('#InformationproModalhdbgcl').modal('hide');

                    },
                    error: function(error) {
                        console.log(error);
                        alert('Data Not Saved');
                    }
                });
            });
        });
    </script>
@endsection
