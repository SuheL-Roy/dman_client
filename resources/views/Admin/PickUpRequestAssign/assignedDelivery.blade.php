@extends('Master.main')
@section('title')
    Assigned Delivery
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-5" style="padding:0px;">
                                    Delivery Order List
                                </h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-info"
                                            style="padding-top:5px; 
                                    padding-bottom:5px; margin-top:0px; margin-bottom:0px;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="sl">SL.</th>
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            <th data-field="merchant_name" data-editable="false">Merchant Name</th>
                                            <th data-field="merchant_phone" data-editable="false">Merchant Phone</th>
                                            <th data-field="customer_name" data-editable="false">Customer Name</th>
                                            <th data-field="customer_number" data-editable="false">Customer Number</th>
                                            <th data-field="customer_address" data-editable="false">Customer Address</th>

                                            <th data-field="type" data-editable="false">Type</th>
                                            <th data-field="partial" data-editable="false">Partial</th>
                                            <th data-field="collection" data-editable="false">Invoice Value</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($order as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->tracking_id }}</td>
                                                <td>{{ $data->business_name }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->customer_phone }}</td>
                                                <td>{{ $data->customer_address }}</td>

                                                <td>{{ $data->type == 'Urgent' ? 'One Hour' : $data->type }}</td>
                                                <td>{{ $data->isPartial == 1 ? 'Available' : 'Not Available' }}</td>
                                                <td>{{ $data->collection }}</td>
                                                <td class="datatable-ct">

                                                    {{-- <div class="btn-group" style=""> --}}
                                                    <div class="btn-group" role="group" aria-label="Basic example">

                                                        <a class="btn btn-success" style="margin-bottom:5px"
                                                            href="{{ route('delivery.assign.deliveredc', ['tracking_id' => $data->tracking_id]) }}"
                                                            title=" Order Delivered ??" type="button">
                                                            Delivered
                                                        </a>

                                                        @if ($data->isPartial == 1)
                                                            <a class="btn btn-info" style="margin-bottom:5px"
                                                                title="Order Partial Delivery ??" type="button"
                                                                onclick="onclickButton('partial','{{ $data->tracking_id }}')">
                                                                Partial
                                                            </a>
                                                        @endif

                                                        {{-- <a class="btn btn-primary" style="margin-bottom:5px"
                                                            title="Order Hold??"
                                                            type="button"onclick="onclickButton('hold','{{ $data->tracking_id }}')">
                                                            Hold
                                                        </a> --}}
                                                        
                                                        @if ($data->is_exchange == 1)
                                                            <a class="btn btn-primary" style="margin-bottom:5px"
                                                                title="Order Hold??"
                                                                type="button"onclick="onclickButton('exchange','{{ $data->tracking_id }}')">
                                                                Exchange
                                                            </a>
                                                        @endif



                                                        @if ($data->return_code)
                                                            <a class="btn btn-danger" style="margin-bottom:5px"
                                                                onclick="onclickButton('cancel','{{ $data->tracking_id }}')">
                                                                Return
                                                            </a>
                                                        @elseif ($data->return_code == null)
                                                            <a class="btn btn-danger"
                                                                href="{{ route('delivery.assign.return.request', ['tracking_id' => $data->tracking_id]) }}"
                                                                style="margin-bottom:5px">
                                                                Return Request
                                                            </a>
                                                        @endif



                                                        <a class="btn btn-warning" style="margin-bottom:5px"
                                                            onclick="onclickButton('schedule','{{ $data->tracking_id }}')">
                                                            Reschedule
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Risd --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">...</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-mdb-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- medium  rishad modal -->
                        <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog"
                            aria-labelledby="mediumModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('delivery.assign.deliveredOption') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="type" id="typeID" value="">
                                        <input type="hidden" name="tracking_id" id="tracking_id" value="">
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title" id="modaltitle"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner" id="return">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Select Reason <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="return_reason_name" class="form-control">
                                                            <option value="">Select Reason</option>
                                                            @foreach ($return as $item)
                                                                <option value="{{ $item->comment }}">{{ $item->comment }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner" id="reshedule">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Select Reason <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="reshedule_reason_name" class="form-control">
                                                            <option value="">Select Reason </option>
                                                            @foreach ($reshedule as $item)
                                                                <option value="{{ $item->comment }}">{{ $item->comment }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner" id="partial">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Select Reason <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <select name="partial_reason_name" class="form-control">
                                                            <option value="">Select Reason</option>
                                                            @foreach ($partial as $item)
                                                                <option value="{{ $item->comment }}">{{ $item->comment }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group-inner" id="total_quantity">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Total Quantity <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input name="total_quantity" type="number" maxlength="4"
                                                            placeholder="total quantity" class="form-control">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group-inner" id="delivery_quantity">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Delivery Quantity <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input name="delivery_quantity" type="number" maxlength="4"
                                                            placeholder="delivery quantity" class="form-control">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group-inner" id="return_quantity">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Return Quantity <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input name="return_quantity" type="number" maxlength="4"
                                                            placeholder="return quantity" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group-inner" id="security_code">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Security Code <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input name="security_code" type="number" maxlength="4"
                                                            placeholder="enter 4 digit code here" class="form-control">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group-inner" id="collection">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Collection <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input name="collection" type="number" class="form-control"
                                                            id="collectionIp">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Note <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <textarea name="note" type="text" class="form-control"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group-inner" id="dateElement">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Date
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input type="date" name="date" class="form-control"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm" id="delivered"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                            <button class="btn btn-success btn-sm" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- Deliverd Modal --}}
                        <div class="modal fade" id="deliveredModal" tabindex="-1" role="dialog"
                            aria-labelledby="mediumModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('delivery.assign.delivered') }}" method="GET">
                                        @csrf

                                        <input type="hidden" name="tracking_id" id="tracking_id1" value="">
                                        <div class="modal-close-area modal-close-df">
                                            <a class="close" data-dismiss="modal" href="#">
                                                <i class="fa fa-close"></i></a>
                                        </div>
                                        <div class="modal-header header-color-modal bg-color-1">
                                            <h4 class="modal-title" id="modaltitle">Order Delivered </h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group-inner" id="security_code">
                                                <div class="row mt-2">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Security Code <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <input name="security_code" type="number" maxlength="4"
                                                            placeholder="enter 4 digit code here" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm" id="delivered"
                                                type="button"data-dismiss="modal">Close</button>
                                            <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                                            <button class="btn btn-success btn-sm" type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                function calculateReturnQuantity() {
                    var totalQuantity = parseInt($('input[name="total_quantity"]').val()) || 0;
                    var deliveryQuantity = parseInt($('input[name="delivery_quantity"]').val()) || 0;
                    var returnQuantity = totalQuantity - deliveryQuantity;
        
                    $('input[name="return_quantity"]').val(returnQuantity);
                }
        
                $('input[name="total_quantity"], input[name="delivery_quantity"]').on('input', function() {
                    calculateReturnQuantity();
                });
            });
        </script>
        
        <script>
            $(document).ready(function() {
                $('.ediT').on('click', function() {
                    var id = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('delivery.assign.edit') }}",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            $('.id').val(data[0]['tracking_id']);
                        }
                    });
                });
                $('#updatE').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('delivery.assign.update') }}",
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'tracking_id': $(".id").val(),
                            'rider': $(".rider").val(),
                        },
                        success: function() {
                            $('#InformationproModalhdbgcl').modal('hide');
                            location.reload();
                        },
                        error: function(error) {
                            console.log(error);
                            alert('Data Not Saved');
                        }
                    });
                });
            });
        </script>

        <script>
            function onclickButton(value, tracking_id) {

                let modal = $('#mediumModal');
                document.getElementById("dateElement").style.display = 'block';
                document.getElementById("collection").style.display = 'none';
                document.getElementById("security_code").style.display = 'none';
                if (value === 'cancel') {
                    let title = modal.find('.modal-title').text('Delivery Return');
                    document.getElementById("dateElement").style.display = 'none';
                    document.getElementById("return").style.display = 'block';
                    document.getElementById("reshedule").style.display = 'none';
                    document.getElementById("partial").style.display = 'none';
                    document.getElementById("total_quantity").style.display = 'none';
                    document.getElementById("delivery_quantity").style.display = 'none';
                    document.getElementById("return_quantity").style.display = 'none';
                    document.getElementById("security_code").style.display = 'block';
                    document.getElementById("typeID").value = 'cancel';
                    document.getElementById("tracking_id").value = tracking_id;
                } else if (value === 'hold') {
                    let title = modal.find('.modal-title').text('Delivery Hold');
                    document.getElementById("dateElement").style.display = 'none';
                    document.getElementById("typeID").value = 'hold';
                    document.getElementById("tracking_id").value = tracking_id;
                } else if (value === 'exchange') {
                    let title = modal.find('.modal-title').text('Exchange');
                    document.getElementById("collection").style.display = 'block';
                    document.getElementById("total_quantity").style.display = 'none';
                    document.getElementById("delivery_quantity").style.display = 'none';
                    document.getElementById("return_quantity").style.display = 'none';
                    document.getElementById("return").style.display = 'none';
                    document.getElementById("reshedule").style.display = 'none';
                    document.getElementById("partial").style.display = 'none';
                    document.getElementById("dateElement").style.display = 'none';
                    document.getElementById("typeID").value = 'exchange';
                    document.getElementById("tracking_id").value = tracking_id;
                } else if (value === 'schedule') {
                    let title = modal.find('.modal-title').text('Delivery Reschedule');
                    document.getElementById("return").style.display = 'none';
                    document.getElementById("reshedule").style.display = 'block';
                    document.getElementById("total_quantity").style.display = 'none';
                    document.getElementById("delivery_quantity").style.display = 'none';
                    document.getElementById("return_quantity").style.display = 'none';
                    document.getElementById("partial").style.display = 'none';
                    document.getElementById("typeID").value = 'schedule';
                    document.getElementById("tracking_id").value = tracking_id;

                } else {
                    let title = modal.find('.modal-title').text('Partial Delivery ');
                    document.getElementById("return").style.display = 'none';
                    document.getElementById("reshedule").style.display = 'none';
                    document.getElementById("partial").style.display = 'none';
                    document.getElementById("total_quantity").style.display = 'block';
                    document.getElementById("delivery_quantity").style.display = 'block';
                    document.getElementById("return_quantity").style.display = 'block';
                    document.getElementById("typeID").value = 'Partial Delivery';
                    document.getElementById("tracking_id").value = tracking_id;
                    document.getElementById("collection").style.display = 'block';
                    document.getElementById("security_code").style.display = 'none';
                    document.getElementById("dateElement").style.display = 'none';

                }
                $('#mediumModal').modal("show");


            }

            function onclickDeliveredButton(tracking_id) {

                let modal = $('#deliveredModal');

                document.getElementById("tracking_id1").value = tracking_id;

                $('#deliveredModal').modal("show");


            }
        </script>
    @endsection
