@extends('Master.main')
@section('title')
    Return Assign
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
                                    Return Assign To Rider
                                </h4>
                                <div class="container col-lg-3">
                                    <input type="text" class="form-control search" placeholder="searching..."
                                        autocomplete="off" autofocus>
                                </div>
                                {{-- <div class="container col-lg-1">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-success"
                                            style="padding-top:5px; 
                                    padding-bottom:5px; margin-top:0px; margin-bottom:0px; text-align:center;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div> --}}
                            </div>
                        </div>
                        <form class="" method="get" action="{{ route('order.move.return.assign.list_scan') }}">
                            @csrf

                            <div class="col-lg-2">
                                <select name="merchant" class="form-control status" required>

                                    <option value="">--- select Merchant ---</option>
                                    @foreach ($merchants as $merchant)
                                        <option value="{{ $merchant->user_id }}"
                                            {{ $selectedMerchant == $merchant->user_id ? 'Selected' : '' }}>
                                            {{ $merchant->business_name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <button type="submit" class="col-lg-1 btn btn-info btn-sm">
                                Load
                            </button>

                        </form>
                        <?php
                        $latestId = App\Admin\ReturnAssign::latest('id')->take(1)->value('id');
                        ?>
                        <form class="" method="POST" action="{{ route('admin.move.return.assign.store_scan') }}">
                            @csrf
                            <input type="hidden" name="merchant" value="{{ $selectedMerchant }}">
                            <div class="col-lg-2">
                                <select name="rider" class="form-control" required>
                                    <option value="">Select Rider</option>
                                    @foreach ($user as $data)
                                        {{-- <option value="For Delivery" {{($status=='Received by Pickup Branch'||$status=='')?'Selected':''}}>For Delivery</option> --}}
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="submit" class="btn btn-success" style="float:right;"
                                    onclick="return confirm('Are You Sure ?')">Confirm
                                </button>
                            </div>
                            <div class="col-lg-1">
                                <a href="{{ route('admin.move.return.assign.print', $latestId) }}" type="btn"
                                    class="btn btn-success">print
                                </a>
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
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th> <input type="checkbox" class="selectall"></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                <th data-field="merchant_name" data-editable="false">Merchant Name</th>
                                                {{-- <th data-field="customer_phone" data-editable="false">Merchant Phone </th>
                                                <th data-field="shop_address" data-editable="false">Merchant Address </th> --}}

                                                <th data-field="cn" data-editable="false">Customer Name</th>
                                                <th data-field="vp" data-editable="false">Customer Phone</th>
                                                <th data-field="cd" data-editable="false">Customer Addrss</th>
                                                {{-- <th data-field="area" data-editable="false">Return Note</th> --}}

                                                <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="status1" data-editable="false">Action</th>
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
                                                    <td>{{ $data->business_name }}</td>
                                                    {{-- <td>{{ $data->mobile }}</td>
                                                    <td>{{ $data->address }}</td> --}}

                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    {{-- <td>{{ $data->delivery_note }}</td> --}}

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
                url: '{{ route('order.move.return.assign.list_scan_store') }}',
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
@endsection
