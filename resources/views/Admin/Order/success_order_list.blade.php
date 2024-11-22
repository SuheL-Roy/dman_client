@extends('Master.main')
@section('title')
    Delivery Order List
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
                                    Delivery Order List
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
                            <form action="{{ route('order.success_order_list') }}" method="GET">
                                @csrf

                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-2" style="padding:0px;">
                                            <label style="float:right;">From </label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="date" name="fromdate" value="{{ $fromdate ?? '' }}"
                                                class="form-control" required />
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
                            </form>
                        </div>
                        {{-- <div class="clearfix"> --}}
                        <form action="{{ route('order.collect_print_generate') }}" method="POST">
                            @csrf



                            <p id="text" style="display: none;">
                                <button type="submit" class="btn btn-success " style="float: right;"
                                    onclick="return confirm('Are You Sure ?')"> <i class="fa fa-check"></i>
                                    Generate</button>
                            </p>

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
                                                <th data-field="m_name" data-editable="false">Create Date</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                @if (Auth::user()->id == 12)
                                                    <th data-field="order_id" data-editable="false">Merchant Order ID</th>
                                                    <th data-field="m_name3" data-editable="false">Business Name</th>
                                                    <th data-field="s_phone" data-editable="false">Merchant Phone</th>
                                                @endif
                                                {{-- <th data-field="s_name" data-editable="false">Merchant Address</th> --}}
                                                <th data-field="c_name" data-editable="false">Customer Name</th>
                                                <th data-field="c_phone" data-editable="false">Customer Phone</th>
                                                <th data-field="c_address" data-editable="false">Customer Address</th>
                                                <th data-field="c_address1" data-editable="false">Amount</th>
                                                <th data-field="collection1" data-editable="false">Collect</th>
                                                <th data-field="collection2" data-editable="false">Type</th>
                                                @if (Auth::user()->id == 1)
                                                    <th data-field="collection3" data-editable="false">Security Code</th>
                                                    <th data-field="collection4" data-editable="false">Return Code</th>
                                                @endif
                                                <th data-field="merchant_pay" data-editable="false">Remarks</th>
                                                <th data-field="status" data-editable="false">Order Status</th>




                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach ($data as $key => $item)
                                                <tr>
                                                    <td><input id="trackings" type="checkbox" class="select_id"
                                                            value="{{ $item->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Dhaka')->format('Y-m-d H:i:s') }}
                                                    </td>
                                                    {{-- <td>{{ $item->tracking_id }}</td> --}}
                                                    <td>
                                                        <a style="color: #ff7c00; font-weight: bold;" target="_blank"
                                                            href="{{ route('order.view', ['id' => $item->tracking_id]) }}">
                                                            {{ $item->tracking_id }}
                                                        </a>
                                                    </td>
                                                    @if (Auth::user()->id == 12)
                                                        <td>{{ $item->order_id }}</td>
                                                        <td>{{ $item->business_name }}</td>
                                                        <td>{{ $item->mobile }}</td>
                                                    @endif
                                                    {{-- <td>{{ $item->address }}</td> --}}
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->customer_phone }}</td>
                                                    <td>{{ $item->customer_address }}</td>
                                                    <td>{{ $item->collection }}</td>
                                                    <td>{{ $item->collect }}</td>
                                                    <td>{{ $item->type }}</td>
                                                    @if (Auth::user()->id == 1)
                                                        <td>{{ $item->security_code }}</td>
                                                        <td>{{ $item->return_code }}</td>
                                                    @endif
                                                    <td>{{ $item->remarks }}</td>
                                                    <td>
                                                        {{-- @if ($item->status == 'Order Placed')
                                                        <span class="text-danger"> Order Placed </span>
                                                    @else
                                                        <span class="text-success"> Successfully Delivered
                                                        </span>
                                                    @endif --}}
                                                        {{ $item->status }}

                                                    </td>


                                                </tr>
                                            @endforeach
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
