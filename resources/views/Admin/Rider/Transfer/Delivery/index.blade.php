@extends('Master.main')
@section('title')
    Delivery Transfer
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h4 class="col-lg-2" style="padding:0px;">
                                    Delivery Transfer @isset($rider->name)
                                    @endisset
                                </h4>
                                <div class="col-lg-3" style="padding:0px;">
                                    <form action="{{ route('rider.transfer.delivery.load') }}">
                                        @csrf
                                        <div class="col-lg-8">
                                            <select name="from_rider" class="form-control" required>
                                                <option value="">Select Rider</option>
                                                @foreach ($riders as $rider)
                                                    <option value="{{ $rider->id }}"
                                                        {{ $rider->id == $from_rider ? 'selected' : '' }}>
                                                        {{ $rider->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info col-lg-3" style="float:right;">Load
                                        </button>
                                    </form>

                                </div>
                                <h4 class="col-lg-1">To</h4>
                                <div class="container col-lg-1">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px;
                                padding-bottom:5px; margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <form class="" method="post"
                                action="{{ route('rider.transfer.delivery.order.bypass') }}">
                                @csrf
                                <input type="hidden" name="from_rider" value="{{ $from_rider }}">
                                <div class="col-lg-2">
                                    <select name="hub" class="form-control" id="sel_hub" required>
                                        <option value="">Select Hub</option>
                                        @foreach ($hub_list as $hub)
                                            <option value="{{ $hub->uid }}">{{ $hub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select name="to_rider" class="form-control" id="to_rider" required>
                                        <option value="">Select Rider</option>

                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success col-lg-1" style="float:right;"
                                    onclick="return confirm('Are You Sure ?')">Confirm
                                </button>

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
                                                    <th> <input type="checkbox" class="selectall"></th>
                                                    <th data-field="sl">SL.</th>
                                                    <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                    <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                    <th data-field="customer_phone" data-editable="false">Customer Phone
                                                    </th>
                                                    <th data-field="customer_address" data-editable="false">Customer Address
                                                    </th>
                                                    <th data-field="area" data-editable="false">Destination</th>
                                                    <th data-field="type" data-editable="false">Type</th>
                                                    <th data-field="collection" data-editable="false">Collection</th>

                                                    <th data-field="status" data-editable="false">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>

                                                @foreach ($orders as $key => $order)
                                                    <tr>
                                                        <td><input type="checkbox" class="select_id"
                                                                value="{{ $order->tracking_id }}" name="tracking_ids[]" />
                                                        </td>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $order->tracking_id }}</td>
                                                        <td>{{ $order->customer_name }}</td>
                                                        <td>{{ $order->customer_phone }}</td>
                                                        <td>{{ $order->customer_address }}</td>
                                                        <td>{{ $order->area }}</td>
                                                        <td>{{ $order->type == 'Urgent' ? 'One Hour' : 'Regular' }}</td>
                                                        <td>{{ $order->collection }}</td>
                                                        <td>{{ $order->status }}</td>


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


                $('#sel_hub').change(function() {


                    $('#to_rider').empty();


                    $('#to_rider').append($('<option>', {
                        value: '',
                        text: 'Select Rider'
                    }));



                    var sel_hub = $("#sel_hub option:selected").val();

                    $.ajax({
                        url: "{{ route('ajaxdata.rider.hub') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            sel_hub: sel_hub
                        },
                        cache: false,
                        dataType: 'json',
                        success: function(dataResult) {

                            var resultData = dataResult.data;

                            $.each(resultData, function(index, row) {

                                $('#to_rider').append($('<option>', {
                                    value: row.id,
                                    text: row.name
                                }));

                            })


                        }
                    });


                });



                $(".selectall").click(function() {
                    var checked = this.checked;
                    if (checked == true) {
                        $('.select_id').prop('checked', true);
                    } else {
                        $('.select_id').prop('checked', false);
                    }
                });
            });
        </script>
    @endsection
