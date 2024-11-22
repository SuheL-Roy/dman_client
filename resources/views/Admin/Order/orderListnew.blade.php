@extends('Master.main')
@section('title')
    All Parcel List
@endsection
@section('content')
    <div id="PrimaryModalalert" class="modal modal-adminpro-general default-popup-PrimaryModal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-close-area modal-close-df">
                    <a class="close" data-dismiss="modal" href="#">
                        <i class="fa fa-close"></i></a>
                </div>
                <div class="modal-header header-color-modal bg-color-1">
                    <h4 class="modal-title"> Parcel Information</h4>
                </div>
                <div class="modal-body" id="textToCopy">
                    <p style="display: none;text-align:left;margin:10px 0px; font-weight:400;" id="msg"
                        class="text-success">Text copied successfully!</p>
                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Tracking ID:</span>
                        <p class="tracking"></p>
                    </div>
                    {{-- <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Business Name:</span>
                        <p class="business"></p>
                    </div> --}}
                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Merchant Name:</span>
                        <p class="merchant"></p>
                    </div>
                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Merchant Phone:</span>
                        <p class="merchant-phone"></p>
                    </div>
                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Customer Name:</span>
                        <p class="customer-name"></p>
                    </div>
                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Customer Phone:</span>
                        <p class="customer-phone"></p>
                    </div>
                    <div class="w-100" style="display: flex;justify-content:start;align-items:start;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold; width:auto;">Customer
                            Address:</span>
                        <p class="customer-address"></p>
                    </div>

                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Collection Amount:</span>
                        <p class="collection-amount"></p>
                    </div>

                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Status:</span>
                        <p class="status"></p>
                    </div>

                    <div class="w-100" style="display: flex;justify-content:start;align-items:center;">
                        <span style="margin-bottom: 0px; margin-right:10px; font-weight:bold;">Update Date:</span>
                        <p class="date"></p>
                    </div>




                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning btn-sm" type="button"data-dismiss="modal">Close</button>
                    <button id="copyButton" class="btn btn-success btn-sm">Copy Text</button>
                </div>

            </div>
        </div>
    </div>
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-2" style="padding:0px;">
                                    All Parcel List
                                </h1>
                                {{-- <div class="container col-lg-1">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                            margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div> --}}
                                {{--  @can('superAdmin')
                            <button type="button" class="btn btn-primary col-lg-2 Primary" 
                                style="float:right;" data-toggle="modal" 
                                data-target="#PrimaryModalalert">Transfer Order
                            </button>
                            @endcan  --}}
                            </div>
                        </div>



                        <div class="clearfix">
                            <form action="{{ route('order.list.order_list_new') }}" method="GET">
                                @csrf

                                {{-- <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-2" style="padding:0px;">
                                            <label style="float:right;">Merchant </label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="date" name="fromdate" value="" class="form-control"
                                                required />
                                        </div>

                                    </div>
                                </div> --}}
                                @if (auth()->user()->role == 1 || auth()->user()->role == 8)
                                    <div class="col-lg-2" style="padding:0px;">

                                        <select name="merchant" class="selectpicker form-control" title="Select Merchant"
                                            data-style="btn-info" data-live-search="true">
                                            <option value="">Select Merchant</option>
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
                                @endif
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3" style="padding:0px;">
                                            <label style="float:right;">From </label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                class="form-control" required />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-3" style="padding:0px;">
                                            <label style="float:right;">To :</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="date" name="todate" value="{{ $todate }}"
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
                                        data-show-columns="true" data-show-pagination-switch="true"
                                        data-show-refresh="true" data-key-events="true" data-show-toggle="true"
                                        data-resizable="true" data-cookie="true" data-cookie-id-table="saveId"
                                        data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="selectall" /></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="m_name" data-editable="false">Create Date</th>
                                                {{-- <th data-field="m_name2" data-editable="false">Time</th> --}}
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                <th data-field="order_id" data-editable="false">Merchant Order ID</th>
                                                <th data-field="m_name3" data-editable="false">Business Name</th>
                                                {{-- <th data-field="s_phone" data-editable="false">Merchant Phone</th> --}}
                                                {{-- <th data-field="s_name" data-editable="false">Merchant Address</th> --}}
                                                <th data-field="c_name" data-editable="false">Customer Name</th>
                                                <th data-field="c_phone" data-editable="false">Customer Phone</th>
                                                <th data-field="c_address" data-editable="false">Customer Address</th>
                                                {{-- <th data-field="c_address1478" data-editable="false">District</th> --}}
                                                <th data-field="c_address45" data-editable="false">Delivery Charge
                                                </th>
                                                <th data-field="c_address455" data-editable="false">COD</th>
                                                {{-- <th data-field="c_address455r" data-editable="false">Payble</th> --}}
                                                <th data-field="c_address1" data-editable="false">Amount</th>
                                                <th data-field="collection1" data-editable="false">Collect</th>
                                                <th data-field="collection2" data-editable="false">Type</th>

                                                @if (Auth::user()->role == 1)
                                                    <th data-field="collection3" data-editable="false">Security Code
                                                    </th>
                                                    <th data-field="collection4" data-editable="false">Return Code
                                                    </th>
                                                @endif
                                                <th data-field="merchant_pay" data-editable="false">Remarks</th>

                                                <th data-field="status" data-editable="false">Order Status</th>

                                                {{-- <th data-field="status3" data-editable="false">Create By</th> --}}

                                                {{-- <th data-field="status2" data-editable="false">Update Date</th> --}}
                                                {{-- <th data-field="status1" data-editable="false">Reason Name</th> --}}
                                                @if (Auth::user()->role == 1)
                                                    <th data-field="action" data-editable="false">Order List Export
                                                        All
                                                        Action
                                                    </th>
                                                @else
                                                    <th data-field="action" data-editable="false">
                                                        Order List Action
                                                    </th>
                                                @endif



                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach ($data as $key => $item)
                                                <tr>
                                                    <td><input id="trackings" type="checkbox" class="select_id"
                                                            value="{{ $item->tracking_id }}" name="tracking_ids[]" />
                                                    </td>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Dhaka')->format('d-m-Y H:i:s') }}
                                                    </td>
                                                    {{-- <td>{{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Dhaka')->format('H:i:s') }}
                                                    </td> --}}
                                                    {{-- <td>{{ $item->tracking_id }}</td> --}}
                                                    <td>
                                                        <a style="color: #ff7c00; font-weight: bold;" target="_blank"
                                                            href="{{ route('order.view', ['id' => $item->tracking_id]) }}">
                                                            {{ $item->tracking_id }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $item->order_id }}</td>
                                                    <td>{{ $item->business_name }}</td>
                                                    {{-- <td>{{ $item->mobile }}</td> --}}
                                                    {{-- <td>{{ $item->address }}</td> --}}
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->customer_phone }}</td>
                                                    <td>{{ $item->customer_address }}</td>
                                                    {{-- <td>{{ $item->district }}</td> --}}
                                                    <td>{{ $item->delivery }}</td>
                                                    <td>{{ $item->cod }}</td>
                                                    <td>{{ $item->merchant_pay }}</td>
                                                    {{-- <td>{{ $item->collection }}</td> --}}
                                                    <td>{{ $item->collect }}</td>
                                                    {{-- <td>{{ $item->type }}</td> --}}
                                                    <td>{{ $item->type == 'Urgent' ? 'Express' : 'Regular' }}</td>
                                                    @if (Auth::user()->role == 1)
                                                        <td>{{ $item->security_code }}</td>
                                                        <td>{{ $item->return_code }}</td>
                                                    @endif

                                                    <td>{{ $item->remarks }}</td>
                                                    <td>

                                                        {{ $item->status }}

                                                    </td>

                                                    {{-- <td>

                                                        {{ $item->status_change_user }}

                                                    </td> --}}

                                                    {{-- <td>
                                                        {{ \Carbon\Carbon::parse($item->updated_at)->timezone('Asia/Dhaka')->format('d-m-Y') }}
                                                    </td> --}}

                                                    {{-- <td>
                                                        {{ $item->reason_name }}
                                                    </td> --}}

                                                    <td class="datatable-ct d-flex justify-content-between">
                                                        <button type="button" class="btn btn-sm btn-primary ediT"
                                                            value="{{ $item->id }}" data-toggle="modal"
                                                            data-target="#PrimaryModalalert"> <i class="fa fa-eye"></i>
                                                        </button>

                                                        @if (Auth::user()->role == 1)
                                                            {{-- <form
                                                                action="{{ route('order.confirm_edit', ['id' => $item->tracking_id]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-warning"
                                                                    style="font-size: 12px;">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </form> --}}
                                                            <a href="{{ route('order.confirm_edit_new', ['id' => $item->tracking_id]) }}"
                                                                class="btn btn-sm btn-warning" style="font-size: 12px;">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        @if (Auth::user()->role == 8 || Auth::user()->role == 1 || Auth::user()->role == 12)
                                                            <a style="font-size: 12px;" class="btn btn-sm btn-success"
                                                                href="{{ route('order.collect.print', ['id' => $item->tracking_id]) }}">

                                                                <i class="fa fa-print"></i>
                                                            </a>
                                                        @endif

                                                        @if (Auth::user()->role == 1)
                                                            <a style="font-size: 12px;" class="btn btn-sm btn-warning"
                                                                href="{{ route('request.assign.cancel', ['id' => $item->tracking_id]) }}"
                                                                onclick="return confirm('Are You Sure You Want To Delete ??')">

                                                                <i class="fa fa-close"></i>
                                                            </a>

                                                            {{-- 
                                                            <form
                                                                action="{{ route('request.assign.delete.order.admin', ['id' => $item->tracking_id]) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    style="font-size: 12px;"
                                                                    onclick="return confirm('Are You Sure You Want To Delete ??')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form> --}}
                                                            <a style="font-size: 12px;" class="btn btn-sm btn-danger"
                                                                href="{{ route('request.assign.admin_order_delete', ['id' => $item->tracking_id]) }}"
                                                                onclick="return confirm('Are You Sure You Want To Delete ??')">

                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        @endIf

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#copyButton").click(function() {
                var textToCopy = document.getElementById("textToCopy");
                var outputText = ''; // Initialize an empty string to build the formatted text

                // Iterate through each div containing a label and value
                $(textToCopy).children('div').each(function() {
                    var label = $(this).find('span').text()
                        .trim(); // Get the label text, trim any excess whitespace
                    var value = $(this).find('p').text()
                        .trim(); // Get the value text, trim any excess whitespace

                    if (label && value) {
                        outputText += '*' + label + '*\n' + value +
                            '\n\n'; // Format output with bold label and double newlines
                    }
                });

                // Copy the formatted text to the clipboard
                navigator.clipboard.writeText(outputText).then(function() {
                    var msg = document.getElementById("msg");
                    msg.style.display = 'block';
                    setTimeout(() => {
                        msg.style.display = 'none';
                    }, 2000);

                }, function() {
                    alert("Error copying text. Please try again.");
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.ediT', function() {
            var id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ route('order.list.order_list_get') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.tracking').text(data[0]['tracking_id']);
                    // $('.business').text(data[0]['merchant_business_name']);
                    $('.merchant').text(data[0]['user_name']);
                    $('.customer-name').text(data[0]['customer_name']);
                    $('.customer-phone').text(data[0]['customer_phone']);
                    $('.customer-address').text(data[0]['customer_address']);
                    $('.merchant-phone').text(data[0]['user_phone']);
                    $('.collection-amount').text(data[0]['collection']);
                    $('.status').text(data[0]['status']);
                    $('.date').text(data[0]['updated_at']);


                }
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
