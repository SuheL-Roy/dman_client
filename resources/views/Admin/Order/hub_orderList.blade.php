@extends('Master.main')
@section('title')
    Confirmed Order List
@endsection
@section('content')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>





    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-2" style="padding:0px;">Confirmed Order List</h1>
                                <div class="container col-lg-10">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            {{-- <div class="col-lg-4" style="padding-right:5px;">
                                                <label style="float:right;"></label>
                                            </div> --}}
                                            <select name="merchant" class="form-control" title="Select Merchant"
                                                id="merchant_id" data-live-search="true">
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
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-4" style="padding-right:5px;">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-8" style="padding-left:5px;">
                                                <input type="date" id="from_date" name="fromdate"
                                                    value="{{ $fromdate ?? '' }}" required class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2" style="padding-right:5px;">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-8" style="padding-left:5px;">
                                                <input type="date" id="to_date" class="form-control" name="todate"
                                                    @if (isset($todate)) value="{{ $todate }}"
                                                        @else
                                                        value="{{ date('Y-m-d') }}" @endif
                                                    required />
                                            </div>

                                        </div>
                                    </div>
                                    <button type="button" id="load" class="col-lg-1 btn btn-success btn-sm">
                                        Load
                                    </button>

                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="sparkline13-graph">
                            <div class="col-12">
                                <table class="user_datatable table table-bordered data-table">
                                    <thead>
                                        <tr>
                                            <th>SL.</th>
                                            {{-- <th data-field="Pickup_date" data-editable="false">Date</th> --}}
                                            <th>Pickup Time</th>
                                            <th>Tracking ID</th>
                                            <th>Order ID</th>
                                            <th>Merchant Name</th>
                                            <th>Business Name</th>
                                            <th>Merchant Phone</th>
                                            <th>Merchant Address</th>
                                            <th>Customer Name</th>
                                            <th>Customer Phone</th>
                                            <th>Destination</th>
                                            <th>Customer Address</th>
                                            <th>Invoice Value</th>
                                            <th>Collected Amount</th>
                                            {{-- <th data-field="pickup_time" data-editable="false">Delivery Date</th> --}}
                                            <th>Type</th>
                                            <th>Security Code</th>
                                            <th>Return Code</th>
                                            <th>Remarks</th>
                                            <th>Status</th>

                                            <th>Action</th>


                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {

            $.noConflict();



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var $fromdate = $("#from_date").val();
            var $todate = $("#to_date").val();





            var table = $('.user_datatable').DataTable({

                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                scrollX: true,
                processing: true,
                serverSide: true,

                ajax: {
                    "url": "{{ route('order.index') }}",
                    "type": "POST",
                    "data": {
                        fromdate: $("#from_date").val(),
                        todate: $("#to_date").val(),

                    },
                },
                columns: [

                    {

                        "data": "serial",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },


                    {
                        data: 'pickup_time',
                        name: 'pickup_time'
                    },



                    {
                        "data": "tracking_id",
                        "render": function(data, type, row, meta) {




                            return '<a style="color: var(--primary)" target="_blank" href={{ route('order.view') }}' +
                                '?id=' + data + '>' + data + '</a>';
                        }
                    },

                    {
                        data: 'order_id',
                        name: 'order_id'
                    },

                    {
                        data: 'name',
                        name: 'name'
                    },

                    {
                        data: 'business_name',
                        name: 'business_name'
                    },

                    {
                        data: 'mobile',
                        name: 'mobile'
                    },

                    {
                        data: 'address',
                        name: 'address'
                    },

                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },

                    {
                        data: 'customer_phone',
                        name: 'customer_phone'
                    },

                    {
                        data: 'area',
                        name: 'area'
                    },

                    {
                        data: 'customer_address',
                        name: 'customer_address'
                    },

                    {
                        data: 'collection',
                        name: 'collection'
                    },

                    {
                        data: 'collect',
                        name: 'collect'
                    },



                    {
                        "data": "type",
                        "render": function(data, type, row, meta) {

                            if (row['status'] == "Order Placed") {


                                if (data == "Urgent") {

                                    return "One Hour";

                                } else {

                                    return data;

                                }

                            } else {

                                if (data == "Urgent") {

                                    return "One Hour";

                                } else {

                                    return "Regular";

                                }
                            }

                        }
                    },






                    {
                        data: 'security_code',
                        name: 'security_code'
                    },

                    {
                        data: 'return_code',
                        name: 'return_code'
                    },



                    {
                        "data": "remarks",
                        "render": function(data, type, row, meta) {


                            if (data == '' && row['deliverynote'] == null) {

                                return data;
                            }
                            if (data != '' && row['deliverynote'] == null) {

                                return data;

                            }
                            if (data != '' && row['deliverynote'] != null) {

                                return data + ' | ' + deliverynote;

                            }



                        }
                    },


                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        "data": "tracking_id",
                        "render": function(data, type, row, meta) {

                            var z_id = {{ $zone_id }};

                            if ((row['status'] == "Order Placed") || (row['status'] ==
                                    "Assigned Pickup Rider")) {
                                if (z_id == row['zone_id']) {

                                    var action =
                                        '<a class="btn" target="_blank" href={{ route('order.collect.print') }}' +
                                        '?id=' + data + '>' +
                                        '<button class="btn btn-success"><i class="fa fa-print"></i> Print</button>' +
                                        '</a>' +
                                        '<a class="btn btn-danger" title="PickUp Cancel ??" onclick=' +
                                        "'" +
                                        'return confirm("Are You Sure You Want To Cancel This ??")' +
                                        "'" + ' href={{ route('request.assign.cancel') }}' +
                                        '?id=' + data + '>' + '<i class="fa fa-close"></i> Cancel' +
                                        '</a>';


                                }
                            } else {

                                var action =
                                    '<a class="btn" target="_blank" href={{ route('order.collect.print') }}' +
                                    '?id=' + data + '>' +
                                    '<button class="btn btn-success"><i class="fa fa-print"></i> Print</button>' +
                                    '</a>';
                            }

                            return action;




                        }
                    },





                    //  '<a class="btn btn-danger" onclick="return confirm('+"'Are You Sure You Want To Cancel This ??'"+')"
                    //title="PickUp Delete ??" href={{ route('request.assign.delete.order.admin') }}'+'?id='+data+'>'+'<i class="fa fa-trash"></i> Delete'+'</a>'







                ]
            });








            $("#load").click(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var $fromdate = $("#from_date").val();
                var $todate = $("#to_date").val();
                var merchant_id = $("#merchant_id").val();


                var table = $('.user_datatable').DataTable({

                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],

                    destroy: true,
                    scrollX: true,
                    processing: true,
                    serverSide: true,

                    ajax: {
                        "url": "{{ route('order.index') }}",
                        "type": "POST",
                        "data": {
                            fromdate: $("#from_date").val(),
                            todate: $("#to_date").val(),
                            merchant_id: $("#merchant_id").val()

                        },
                    },
                    columns: [

                        {

                            "data": "serial",
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },


                        {
                            data: 'pickup_time',
                            name: 'pickup_time'
                        },



                        {
                            "data": "tracking_id",
                            "render": function(data, type, row, meta) {




                                return '<a style="color: var(--primary)" target="_blank" href={{ route('order.view') }}' +
                                    '?id=' + data + '>' + data + '</a>';
                            }
                        },

                        {
                            data: 'order_id',
                            name: 'order_id'
                        },

                        {
                            data: 'name',
                            name: 'name'
                        },

                        {
                            data: 'business_name',
                            name: 'business_name'
                        },

                        {
                            data: 'mobile',
                            name: 'mobile'
                        },

                        {
                            data: 'address',
                            name: 'address'
                        },

                        {
                            data: 'customer_name',
                            name: 'customer_name'
                        },

                        {
                            data: 'customer_phone',
                            name: 'customer_phone'
                        },

                        {
                            data: 'area',
                            name: 'area'
                        },

                        {
                            data: 'customer_address',
                            name: 'customer_address'
                        },

                        {
                            data: 'collection',
                            name: 'collection'
                        },

                        {
                            data: 'collect',
                            name: 'collect'
                        },



                        {
                            "data": "type",
                            "render": function(data, type, row, meta) {

                                if (row['status'] == "Order Placed") {


                                    if (data == "Urgent") {

                                        return "One Hour";

                                    } else {

                                        return data;

                                    }

                                } else {

                                    if (data == "Urgent") {

                                        return "One Hour";

                                    } else {

                                        return "Regular";

                                    }
                                }

                            }
                        },






                        {
                            data: 'security_code',
                            name: 'security_code'
                        },

                        {
                            data: 'return_code',
                            name: 'return_code'
                        },



                        {
                            "data": "remarks",
                            "render": function(data, type, row, meta) {


                                if (data == '' && row['deliverynote'] == null) {

                                    return data;
                                }
                                if (data != '' && row['deliverynote'] == null) {

                                    return data;

                                }
                                if (data != '' && row['deliverynote'] != null) {

                                    return data + ' | ' + deliverynote;

                                }



                            }
                        },


                        {
                            data: 'status',
                            name: 'status'
                        },

                        {
                            "data": "tracking_id",
                            "render": function(data, type, row, meta) {

                                var z_id = {{ $zone_id }};

                                if ((row['status'] == "Order Placed") || (row['status'] ==
                                        "Assigned Pickup Rider")) {
                                    if (z_id == row['zone_id']) {

                                        var action =
                                            '<a class="btn" target="_blank" href={{ route('order.collect.print') }}' +
                                            '?id=' + data + '>' +
                                            '<button class="btn btn-success"><i class="fa fa-print"></i> Print</button>' +
                                            '</a>' +
                                            '<a class="btn btn-danger" title="PickUp Cancel ??" onclick=' +
                                            "'" +
                                            'return confirm("Are You Sure You Want To Cancel This ??")' +
                                            "'" +
                                            ' href={{ route('request.assign.cancel') }}' +
                                            '?id=' + data + '>' +
                                            '<i class="fa fa-close"></i> Cancel' + '</a>';


                                    }
                                } else {

                                    var action =
                                        '<a class="btn" target="_blank" href={{ route('order.collect.print') }}' +
                                        '?id=' + data + '>' +
                                        '<button class="btn btn-success"><i class="fa fa-print"></i> Print</button>' +
                                        '</a>';
                                }

                                return action;




                            }
                        },





                        //  '<a class="btn btn-danger" onclick="return confirm('+"'Are You Sure You Want To Cancel This ??'"+')"
                        //title="PickUp Delete ??" href={{ route('request.assign.delete.order.admin') }}'+'?id='+data+'>'+'<i class="fa fa-trash"></i> Delete'+'</a>'







                    ]
                });






            });




        });
    </script>
@endsection
