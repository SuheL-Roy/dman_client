@extends('Master.main')
@section('title')
    Income List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Income List</h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                @can('superAdmin')
                                    <button type="button" class="btn btn-info col-lg-2 Primary" style="float:right;"
                                        data-toggle="modal" data-target="#PrimaryModalalert"> Add Income
                                    </button>
                                @endcan
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('Income.list.store') }}" method="POST">
                                        @csrf

                                        <?php
                                        $s = $sl + 1;
                                        $p = date('Ydm') . $s;
                                        ?>
                                        <input type="hidden" class="form-control" value="VN{{ $p }}"
                                            id="" name="voucher_no">
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title"> IncomeList Information</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Date <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="date" name="date" autocomplete="date"
                                                            class="form-control" placeholder="Name"
                                                            value="{{ date('Y-m-d') }}" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Income Type <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="income_type" class="form-control" required>
                                                            <option value="">Select Income Type</option>
                                                            @foreach ($income_type as $item)
                                                                <option value="{{ $item->type_name }}">
                                                                    {{ $item->type_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Expense For <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="income_for" class="form-control" required>
                                                            <option value="">Select Income For</option>
                                                            @foreach ($merchant as $data)
                                                                <option value="{{ $data->business_name }}">
                                                                    {{ $data->business_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Amount <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="amount" class="form-control"
                                                            placeholder="User Amount" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Details <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="details" class="form-control"
                                                            placeholder="User details" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                            <button class="btn btn-success btn-sm" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div id="EditModal" class="modal modal-adminpro-general default-popup-PrimaryModal fade"
                            role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('Income.list.update') }}" method="POST">
                                        @csrf

                                        <input type="hidden" class="form-control" value="VN{{ $p }}"
                                            id="" name="voucher_no">
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title"> Income List nformation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Date <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>

                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="date" name="date" autocomplete="date"
                                                            class="form-control date" placeholder="Name"
                                                            value="{{ date('Y-m-d') }}" required />
                                                        <input type="hidden" class="id" name="id">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Expense Type <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="income_type" class="form-control expense-type"
                                                            required>
                                                            @foreach ($income_type as $item)
                                                                <option value="{{ $item->type_name }}">
                                                                    {{ $item->type_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Expense For <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="income_for" class="form-control expense-for"
                                                            required>
                                                            @foreach ($merchant as $data)
                                                                <option value="{{ $data->business_name }}">
                                                                    {{ $data->business_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Amount <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="amount" class="form-control amount"
                                                            placeholder="User Amount" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Details <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="text" name="details" class="form-control details"
                                                            placeholder="User details" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
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
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            {{--  <th data-field="id" data-editable="false">Employee ID</th> 
                                             --}}
                                            <th data-field="name" data-editable="false">Date</th>
                                            <th data-field="voucher" data-editable="false">Voucher No</th>

                                            <th data-field="email" data-editable="false">Expense Type</th>
                                            <th data-field="mobile" data-editable="false">Expense For</th>
                                            <th data-field="amount" data-editable="false">Amount</th>
                                            <th data-field="details" data-editable="false">Details</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($income_list as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->date }}</td>
                                                <td>{{ $data->voucher_no }}</td>
                                                <td>{{ $data->income_type }}</td>
                                                <td>{{ $data->income_for }}</td>
                                                <td>{{ $data->amount }}</td>
                                                <td>{{ $data->details }}</td>

                                                <td class="datatable-ct">

                                                    <button style="font-size: 18px;" type="button"
                                                        value="{{ $data->id }}" class="btn btn-warning ediT btn-xs"
                                                        data-toggle="modal" data-target="#EditModal">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <a style="font-size: 12px;" class="btn btn-danger"
                                                        href="{{ route('Income.list.destroy', ['id' => $data->id]) }}"
                                                        onclick="return confirm('Are You Sure You Want To Delete ??')">

                                                        <i class="fa fa-trash"></i>
                                                    </a>




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

    <script>
        $(document).ready(function() {
            $('.ediT').on('click', function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('Income.list.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.date').val(data[0]['date']);
                        $('.expense-type').val(data[0]['income_type']);
                        $('.expense-for').val(data[0]['income_for']);
                        $('.amount').val(data[0]['amount']);
                        $('.details').val(data[0]['details']);
                    }
                });
            });

        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            var y = document.getElementById("password-confirm");
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
            }
        }
    </script>
@endsection
