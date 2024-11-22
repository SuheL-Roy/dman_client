@extends('Master.main')
@section('title')
    Order List
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-3" style="padding:0px;">
                                    Order List <small> ( In Destination Hub ) </small>
                                </h1>
                                <div class="container col-lg-3">
                                    <a target="blank__" href="{{ route('order.destination_scan') }}" type="btn"
                                    class="btn btn-success">Destination Hub By Scan</a>
                                </div>
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

                            </div>
                        </div>


                    <form action="{{ route('order.destination.collect.all') }}" method="GET">
                            @csrf

                            <p id="text" style="display: none;">
                                <button type="submit" class="btn btn-success " style="float: right;"
                                    onclick="return confirm('Are You Sure ?')"> <i class="fa fa-check"></i> Collect</button>
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
                                    data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="selectall" /></th>
                                              <th data-field="sl">SL.</th>
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>

                                            <th data-field="m_name" data-editable="false">
                                                Merchant Name</th>
                                            <th data-field="m_phone" data-editable="false">
                                                Merchant Phone</th>
                                            <th data-field="m_address" data-editable="false">
                                                Merchant Address</th>
                                            <th data-field="customer_name" data-editable="false">
                                                Customer Name</th>
                                            <th data-field="customer_phone" data-editable="false">Customer Mobile</th>
                                            {{-- <th data-field="area" data-editable="false">Zone</th> --}}
                                            <th data-field="collection" data-editable="false">Collection</th>
                                            {{-- <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>
                                            <th data-field="pickup_date" data-editable="false">Pickup Date</th> --}}
                                            {{-- <th data-field="pickup_time" data-editable="false">Pickup Time</th> --}}
                                            <th data-field="typr" data-editable="false">Delivery Type</th>
                                            <th data-field="pickup_time" data-editable="false">Status</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($data as $data)
                                            {{-- @if ($data->area == $my_string) --}}
                                            <tr>
                                               <td><input id="trackings" type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->tracking_id }}</td>

                                                <td>{{ $data->business_name }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ $data->address }}</td>

                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->customer_phone }}</td>
                                                {{-- <td>{{ $data->area }}</td>  --}}
                                                <td>{{ $data->collection }}</td>
                                                {{-- <td>{{ $data->merchant_pay }}</td>
                                                <td>{{ $data->pickup_date }}</td> --}}
                                                <td>{{ $data->type == 'Urgent' ? 'One Hour' : 'Reqular' }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>
                                                    @if ($data->status == 'Return Reach For Branch')
                                <a href="{{ route('order.move.return.assign.agent', ['id' => $data->tracking_id]) }}"
                                                            class="btn btn-success"
                                        onclick="return confirm('Are you sure to collect this Return ??')"
                                                            title="Reached In Return Assign ??">
                                                            COLLECT
                                                        </a>  
                                                    @endif

                                                    @if ($data->status == 'Reach to Branch')
                                <a href="{{ route('order.destiny', ['id' => $data->tracking_id]) }}"
                                                            class="btn btn-success"
                                      onclick="return confirm('Are You Sure ??')"
                                                           title="Reached In Destination Hub ??">
                                                            COLLECT
                                                        </a>  
                                                    @endif



                                                </td>
                                            </tr>
                                            {{-- @endif --}}
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
