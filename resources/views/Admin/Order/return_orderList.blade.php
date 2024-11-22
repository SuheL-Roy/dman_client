@extends('Master.main')
@section('title')
    Reschedule Order List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-4" style="padding:0px;">Reschedule Order List</h1>
                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <form action="{{route('order.return_list2')}}" method="POST">
                            @csrf
                            <p id="text" style="display: none;">
                                <button type="submit" class="btn btn-success " style="float: right;"
                                    onclick="return confirm('Are You Sure ?')"> <i class="fa fa-check"></i>
                                    Re-Asign</button>
                            </p>

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
                                                {{-- <th data-field="state" data-checkbox="true" class="selectall"></th> --}}
                                                <th data-field="sl">SL.</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                {{--   <th data-field="order_id" data-editable="false">Order ID</th> --}}


                                                <th data-field="s_name" data-editable="false">Merchant Name</th>
                                                <th data-field="e" data-editable="false">Merchant Phone</th>
                                                {{-- <th data-field="s_name" data-editable="false">S. Name</th>
                                            <th data-field="s_phone" data-editable="false">S. Phone</th>
                                            <th data-field="s_address" data-editable="false">S. Address</th> --}}
                                                <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                <th data-field="customer_phone" data-editable="false">Customer Mobile</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                <th data-field="destination" data-editable="false">Destination</th>
                                                <th data-field="collection" data-editable="false">Collection</th>
                                                <th data-field="status_order" data-editable="false">Status</th>
                                                <th data-field="delivery_date" data-editable="false">Delivery Date</th>
                                                <th data-field="delivery_note" data-editable="false">Notes</th>

                                                <th data-field="status" data-editable="false">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($data as $data)
                                                <tr>
                                                    <td><input id="trackings" type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    <td>{{ $data->business_name }}</td>
                                                    <td>{{ $data->mobile }}</td>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>{{ $data->area }}</td>
                                                    <td>{{ $data->collection }}</td>
                                                    <td>{{ $data->status }}</td>
                                                    <td>{{ $data->delivery_date }}</td>
                                                    <td>{{ $data->delivery_note }}</td>

                                                    <td>
                                                        <a href="{{ route('order.return.delivery.assign', ['id' => $data->tracking_id]) }}"
                                                            class="btn btn-success "
                                                            onclick="return confirm('Are You Sure ??')"
                                                            title="Move to Delivery Assign ??">
                                                            <i class="fa fa-check-circle"> Re-Assign</i>
                                                        </a>


                                                        <a class="btn btn-danger"
                                                            onclick="onclickButton('cancel','{{ $data->tracking_id }}')"><i
                                                                class="fa fa-close"></i> Cancel</a>

                                                        <a class="btn btn-warning "
                                                            onclick="onclickButton('schedule','{{ $data->tracking_id }}')"><i
                                                                class="fa fa-calendar"></i> Reschedule</a>

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

    <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            {{-- <div class="modal-content"> --}}
            <div class="modal-content">
                <form action="{{ route('order.delivery.data.update') }}" method="GET">
                    @csrf
                    <input type="hidden" name="tracking_id" id="tracking_id" value="">
                    <input type="hidden" name="type" id="typeID" value="">
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
                                        @foreach ($delivery_category as $item)
                                            <option value="{{ $item->comment }}">{{ $item->comment }}
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
                                        Note <span class="table-project-n">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                    <textarea name="note" type="text" class="form-control" required></textarea>
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
                        <button class="btn btn-warning btn-sm" type="button"data-dismiss="modal">Close</button>
                        <button class="btn btn-danger btn-sm" type="reset">Clear</button>
                        <button class="btn btn-success btn-sm" type="submit">Submit</button>
                    </div>
                </form>
            </div>
            {{-- </div> --}}
        </div>

    </div>


    <script>
        function onclickButton(value, tracking_id) {


            let modal = $('#mediumModal');


            document.getElementById("dateElement").style.display = 'block';
            if (value === 'cancel') {
                let title = modal.find('.modal-title').text('Delivery Cancel');
                document.getElementById("dateElement").style.display = 'none';
                document.getElementById("typeID").value = 'cancel';
                document.getElementById("tracking_id").value = tracking_id;
            } else if (value === 'schedule') {
                let title = modal.find('.modal-title').text('Delivery Reschedule');
                document.getElementById("typeID").value = 'schedule';
                document.getElementById("return").style.display = 'none';
                document.getElementById("tracking_id").value = tracking_id;
            }

            $('#mediumModal').modal("show");


        }
        // function onclickButton(value, tracking_id) {

        //     let modal = $('#mediumModal');
        //     document.getElementById("dateElement").style.display = 'block';
        //     let title = modal.find('.modal-title').text('Delivery Reschedule');
        //     document.getElementById("tracking_id").value = tracking_id;
        //     $('#mediumModal').modal("show");


        // }
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
                        }).get();
                    if (value == values.length) {
                        $('.select_id').prop('checked', true);
                    }


                } else if ($(this).is(":not(:checked)")) {
                    value = value - 1;
                    if (value == 0) {
                        $('.select_id').prop('checked', false);
                        text.style.display = "none";
                    }

                }
            });


            $(".selectall").click(function() {
                var text = document.getElementById("text");
                var checked = this.checked;

                if (checked == true) {
                    $('.select_id').prop('checked', true);
                    text.style.display = "block";
                } else {
                    $('.select_id').prop('checked', false);
                    text.style.display = "none";
                }
            });
        });
    </script>
@endsection
