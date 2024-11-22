@extends('Master.main')
@section('title')
    Incomplete Order
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
                                    Order Incomplete List <small> ( My Incomplete Order) </small>
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
                                            <th data-field="shop_name" data-editable="false">S. Name</th>
                                            <th data-field="shop_phone" data-editable="false">S. Phone</th>
                                            <th data-field="shop_address" data-editable="false">S. Address</th>
                                            <th data-field="customer_name" data-editable="false">C. Name</th>
                                            <th data-field="customer_phone" data-editable="false">C. Phone</th>
                                            <th data-field="customer_address" data-editable="false">C. Address</th>
                                            <th data-field="area" data-editable="false">Area</th>
                                            <th data-field="type" data-editable="false">Type</th>
                                            <th data-field="partial" data-editable="false">Partial</th>
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
                                                <td>{{ $data->shop_name }}</td>
                                                <td>{{ $data->shop_phone }}</td>
                                                <td>{{ $data->shop_address }}</td>
                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->customer_phone }}</td>
                                                <td>{{ $data->customer_address }}</td>
                                                <td>{{ $data->area }}</td>
                                                <td>{{ $data->type == 'Urgent' ? 'One Hour' : $data->type }}</td>
                                                <td>{{ $data->isPartial == 1 ? 'Available' : 'Not Available' }}</td>
                                                <td class="datatable-ct">
                                                    @if ($data->isPartial == 0)
                                                        <a href="{{ route('delivery.assign.delivered', ['id' => $data->tracking_id]) }}"
                                                            onclick="return confirm('Are You Sure ??')"
                                                            class="btn btn-success btn-xs" title="Order Delivered ??"
                                                            type="button"><i class="fa fa-check"></i></a>
                                                    @else
                                                        <a class="btn btn-success btn-xs" title="Order Delivered ??"
                                                            type="button"
                                                            onclick="onclickButton('partial','{{ $data->tracking_id }}')"><i
                                                                class="fa fa-check"></i></a>
                                                    @endif

                                                    {{-- <a class="btn btn-primary btn-xs"
                                            title="Order Hold??" type="button"onclick="onclickButton('hold','{{ $data->tracking_id }}')"><i class="fa fa-spinner" ></i></a>

                                            <a class="btn btn-danger btn-xs"
                                             onclick="onclickButton('cancel','{{ $data->tracking_id }}')" ><i class="fa fa-close"></i></a>
                                            <a class="btn btn-warning btn-xs"
                                            onclick="onclickButton('schedule','{{ $data->tracking_id }}')" 
                                             
                                             ><i class="fa fa-calendar"></i></a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        <label class="login2 pull-right pull-right-pro">
                                                            Note <span class="table-project-n">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                        <textarea name="note" type="text" class="form-control" required></textarea>
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
                                                            required></input>
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
                                                        <input type="date" name="date" class="form-control" />
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
                if (value === 'cancel') {
                    let title = modal.find('.modal-title').text('Delivery Cancel');
                    document.getElementById("dateElement").style.display = 'none';
                    document.getElementById("typeID").value = 'cancel';
                    document.getElementById("tracking_id").value = tracking_id;
                } else if (value === 'hold') {
                    let title = modal.find('.modal-title').text('Delivery Hold');
                    document.getElementById("dateElement").style.display = 'none';
                    document.getElementById("typeID").value = 'hold';
                    document.getElementById("tracking_id").value = tracking_id;
                } else if (value === 'schedule') {
                    let title = modal.find('.modal-title').text('Delivery Reschedule');
                    document.getElementById("typeID").value = 'schedule';
                    document.getElementById("tracking_id").value = tracking_id;

                } else {
                    let title = modal.find('.modal-title').text('Partial Delivery ');
                    document.getElementById("typeID").value = 'Partial Delivery';
                    document.getElementById("tracking_id").value = tracking_id;
                    document.getElementById("collection").style.display = 'block';
                    document.getElementById("dateElement").style.display = 'none';

                }
                $('#mediumModal').modal("show");


            }
        </script>
    @endsection
