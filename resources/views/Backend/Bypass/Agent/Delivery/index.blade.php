@extends('Master.main')
@section('title')
    Delivery Assign
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-2" style="padding:0px;">
                                    Delivery Order Bypass
                                </h1>

                                <div class="col-lg-3" style="padding:0px;">
                                    <form action="{{ route('agent.delivery.bypass.load') }}">
                                        @csrf
                                        <div class="col-lg-8">
                                            <select name="form_rider" class="form-control" required>
                                                <option value="">Select Rider</option>

                                                @foreach ($riders as $rider)
                                                    <option value="{{ $rider->id }}"
                                                        {{ $rider->id == $riderid ? 'selected' : '' }}>
                                                        {{ $rider->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info col-lg-3" style="float:right;">Load
                                            <i class="fa fa-spineer"></i>
                                        </button>
                                    </form>
                                </div>



                                <div class="container col-lg-4">
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

                        <form class="" method="post" action="{{ route('agent.delivery.bypass.order.delivery') }}">
                            @csrf
                            <input type="hidden" name="form_rider" value="{{ $riderid }}">
                            <div class="col-lg-2">
                                <select name="to_rider" class="form-control" required>
                                    <option value="">Select Rider</option>
                                    @foreach ($riders as $rider)
                                        <option value="{{ $rider->id }}">
                                            {{ $rider->name }}</option>
                                    @endforeach
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
                                        data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true"
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th> <input type="checkbox" class="selectall"></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                  <th data-field="business_name" data-editable="false">Business Name</th>
                                                <th data-field="merchant_phone" data-editable="false">Merchant Phone</th>
                                                <th data-field="merchant_address" data-editable="false">Merchant Address
                                                <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                <th data-field="customer_phone" data-editable="false">Customer Phone</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>
                                                <th data-field="area" data-editable="false">Destination</th>
                                                <th data-field="type" data-editable="false">Type</th>
                                                <th data-field="collection" data-editable="false">Collection</th>
                                                 <th data-field="rider" data-editable="false">Rider Name</th>

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
                                                    <td>{{ $order->business_name }}</td>
                                                    <td>{{ $order->mobile }}</td>
                                                    <td>{{ $order->address }}</td> 
                                                    <td>{{ $order->customer_name }}</td>
                                                    <td>{{ $order->customer_phone }}</td>
                                                    <td>{{ $order->customer_address }}</td>
                                                    <td>{{ $order->area }}</td>
                                                    <td>{{ $order->type=='Urgent'?'One Hour':'Regular' }}</td>
                                                    <td>{{ $order->collection }}</td>
                                                    <td>{{ $order->rider_info->name }}</td>
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
