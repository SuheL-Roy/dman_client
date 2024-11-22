@extends('Master.main')
@section('title')
    Payment Processing List
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
                                    Payment Processing List
                                </h1>
                                <div class="container col-lg-1">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                {{--  @can('superAdmin')
                            <button type="button" class="btn btn-primary col-lg-2 Primary" 
                                style="float:right;" data-toggle="modal" 
                                data-target="#PrimaryModalalert">Transfer Order
                            </button>
                            @endcan  --}}
                            </div>
                        </div>



                        <div class="clearfix">
                            {{-- <form action="{{ route('order.list.order_list_date_wise') }}" method="GET">
                                @csrf

                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-2" style="padding:0px;">
                                            <label style="float:right;">From </label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="date" name="fromdate" value="" class="form-control"
                                                required />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-2" style="padding:0px;">
                                            <label style="float:right;">To :</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="date" name="todate" value="{{ $today }}"
                                                class="form-control" />
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Load</button>
                            </form> --}}
                        </div>
                        {{-- <div class="clearfix"> --}}
                        <form action="{{ route('order.collect_print_generate') }}" method="POST">
                            @csrf



                            {{-- <p id="text" style="display: none;">
                                <button type="submit" class="btn btn-success " style="float: right;"
                                    onclick="return confirm('Are You Sure ?')"> <i class="fa fa-check"></i>
                                    Generate</button>
                            </p> --}}

                            {{-- </div> --}}
                            <div class="clearfix"></div>

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
                                                <th><input type="checkbox" class="selectall" /></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="create_date">Create Date</th>
                                                <th data-field="m_name" data-editable="false">Invoice Id</th>
                                                <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="status1" data-editable="false">Create By</th>
                                                <th data-field="tracking_id" data-editable="false">Payable</th>
                                                <th data-field="tracking_id1" data-editable="false">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach ($total_paymentProcessing as $key => $item)
                                                <tr>
                                                    <td><input type="checkbox" class="select_id" /></td>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                                    <td>{{ $item->invoice_id }}</td>


                                                    <td>

                                                        {{ $item->status }}

                                                    </td>
                                                    <td>

                                                        {{ $item->users_name }}

                                                    </td>
                                                    <td>{{ $item->t_payable }}</td>
                                                    <td><a href="{{ route('order.payment_print_all', ['invoice_id' => $item->invoice_id]) }}" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-eye"></i>
                                                        show
                                                    </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="text-align:right; font-weight:bold;">Total :</td>
                                                <td style="text-align: center;font-weight:bold;">{{ $total_payable }}
                                                </td>

                                                <td></td>
                                                <td></td>
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
            $('#table').DataTable({
                paging: true,
                searching: true,
                // Add other DataTables options as needed
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var value = 0;
            $(".select_id").change(function() {
                var text = document.getElementById("text");
                if ($(this).is(":checked")) {
                    text.style.display = "block";
                    value = value + 1;
                    var values = $("input[name='tracking_ids[]']")
                        .map(function() {
                            return $(this).val();
                        })
                        .get();
                    if (value == values.length) {
                        $(".select_id").prop("checked", true);
                    }
                } else if ($(this).is(":not(:checked)")) {
                    value = value - 1;
                    if (value == 0) {
                        $(".select_id").prop("checked", false);
                        text.style.display = "none";
                    }
                }
            });

            $(".selectall").click(function() {
                var text = document.getElementById("text");
                var checked = this.checked;

                if (checked == true) {
                    $(".select_id").prop("checked", true);
                    text.style.display = "block";
                } else {
                    $(".select_id").prop("checked", false);
                    text.style.display = "none";
                }
            });
        });
    </script>
@endsection
