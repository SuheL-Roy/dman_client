@extends('Master.main')
@section('title')
    Transfer Head Office Scan
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h5 class="col-lg-2" style="padding:0px;">
                                    Transfer to Hub
                                </h5>

                                {{-- <div class="container col-lg-1">
                                    <a href="{{ route('delivery.assign.delivery_assign_by_scan') }}" type="btn"
                                    class="btn btn-success">Transfer To hub By Scan</a>
                                </div>
                                <div class="container col-lg-1">

                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                    
                                </div> --}}

                                <div class="col-lg-3">
                                    <input type="text" class="form-control search" placeholder="searching..."
                                        autocomplete="off" autofocus>
                                </div>

                                <form class="" method="get" action="{{ route('order.transfer_index_scan') }}">
                                    @csrf

                                    <div class="col-lg-2">

                                        <select name="area" class="form-control area" required>
                                            <option value="">Select Destination Hub</option>
                                            @foreach ($area_list as $value)
                                                <option value="{{ $value->zone_name }}"
                                                    {{ $area == $value->zone_name ? 'selected' : '' }}>
                                                    {{ $value->zone_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <button type="submit" class="col-lg-1 btn btn-info btn-sm">
                                        Load
                                    </button>

                                </form>




                            </div>
                        </div>



                        <form class="" method="post" action="{{ route('order.transfer.agent.store_scan') }}">
                            @csrf

                            <input type="hidden" name="area" value="{{ $area ?? '' }}" />

                            <div class="col-lg-2" style="padding-right:10px; ">
                                <select name="rider" class="form-control" required>
                                    <option value="">Select Rider</option>
                                    @foreach ($user as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success col-lg-1" style="float:left;"
                                onclick="return confirm('Are You Sure ?')">Confirm
                            </button>

                            <div class="clearfix">
                                {{-- <p id="text" style="display: none;">
                                    <button type="submit" class="btn btn-danger" style="float: right;"
                                        onclick="return confirm('Are You Sure Want To Remove ?')"> <i class="fa fa-trash"></i></button>
                                </p> --}}
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
                                                <th> <input type="checkbox" class="selectall"></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                {{--                <th data-field="order_id" data-editable="false">Order ID</th> --}}
                                                <th data-field="merchant" data-editable="false">Merchant Name</th>
                                                {{-- <th data-field="mobile_no" data-editable="false">Merchant Phone</th>
                                                <th data-field="business_name" data-editable="false">Merchant Address</th> --}}
                                                <th data-field="customer_name" data-editable="false">Customer</th>
                                                <th data-field="customer_mobile_no" data-editable="false">Customer Mobile
                                                    No.</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                <th data-field="type" data-editable="false">Type</th>
                                                <th data-field="destination" data-editable="false">Destination</th>
                                                <th data-field="pickup_date" data-editable="false">Status</th>
                                                <th data-field="pickup_date1" data-editable="false">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>

                                            @foreach ($order as $data)
                                                <tr>
                                                    <td><input type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>
                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    {{-- <td>{{ $data->order_id }}</td> --}}
                                                    <td>{{ $data->business_name }}</td>
                                                    {{-- <td>{{ $data->user_info->mobile }}</td>
                                                    <td>{{ $data->user_info->address }}</td> --}}
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>
                                                        @if ($data->type == 'Urgent')
                                                            One Hour
                                                        @elseif ($data->type == 'Regular')
                                                            Regular
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->hub }}</td>
                                                    <td>{{ $data->status }}</td>
                                                    <td> <a href="{{ route('order.transfer.hub.cancel', ['id' => $data->tracking_id]) }}"
                                                            class="btn"
                                                            onclick="return confirm('Are You Sure  To Remove this ??')">

                                                            <button class="btn btn-danger" type="button"> <i
                                                                    class="fa fa-trash"></i></button>
                                                        </a></td>
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
        // $(document).on('keyup', '.search', function() {
        //     if (event.keyCode === 13) { // 13 is the keycode for the Enter key
        //         event.preventDefault();
        //         scan();
        //     }
        // });
        // $(document).on('keyup', '.search', function(event) {
        //     if (event.keyCode === 13) { // 13 is the keycode for the Enter key
        //         event.preventDefault();
        //         // scan();

        //     }
        // });
        $('.search').keydown(function(e) {
            // e.preventDefault();
            if (e.keyCode == 13) {
                e.preventDefault();
                // // alert('you pressed enter ^_^');
                // test();
                scan();

            }
        })
    </script>

    <script>
        function scan() {

            var query = $('.search').val();

            $.ajax({
                url: '{{ route('order.transfer_index_scan_store') }}',
                type: 'POST',
                data: {
                    'name': query,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    location.reload();


                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    location.reload();
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
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
