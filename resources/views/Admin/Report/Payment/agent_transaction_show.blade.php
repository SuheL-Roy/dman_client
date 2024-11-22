@extends('Master.main')
@section('title')
    Collect Amount Rider
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-6" style="padding:0px;">
                                    Transaction Show <small> ( {{ $rider->name }} ) </small>
                                </h1>
                                <div class="container col-lg-6">
                                    @if (session('message'))
                                        <div class="alert alert-dismissible alert-info"
                                            style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px; text-align:center;">
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
                                            {{-- <th data-field="state" data-checkbox="true"></th> --}}
                                            <th data-field="sl">SL.</th>
                                            <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                            <th data-field="rider_name" data-editable="false">Hub Name</th>
                                            <th data-field="business_name" data-editable="false">Merchant Name</th>
                                            <th data-field="s_name" data-editable="false">Mechant Phone</th>
                                            <th data-field="addsdf" data-editable="false">Mechant address</th>

                                            <th data-field="customer_name" data-editable="false">Customer Name</th>
                                            <th data-field="customer_phone" data-editable="false">Customer Phone</th>
                                            <th data-field="customer_address" data-editable="false">Customer Address</th>
                                            <th data-field="area" data-editable="false">Destination</th>

                                            <th data-field="status" data-editable="false">Status</th>

                                            <th data-field="collection" data-editable="false">Collection</th>
                                            <th data-field="collect" data-editable="false">Collected</th>
                                            {{-- <th data-field="action">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($orders as $data)
                                            <tr>
                                                {{-- <td></td> --}}
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->tracking_id }}</td>
                                                <td>{{ $rider->name }}</td>
                                                <td>{{ $data->business_name }}</td>
                                                <td>{{ $data->address }}</td>
                                                <td>{{ $data->mobile }}</td>


                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->customer_phone }}</td>
                                                <td>{{ $data->customer_address }}</td>
                                                <td>{{ $data->area }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>{{ $data->collection }}</td>
                                                <td>{{ $data->collect ?? 0 }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="11" style="text-align:right; "><b>Total Collected Amount:</b>
                                                &nbsp;</td>
                                            {{--  <td> &nbsp;&nbsp; {{ $tCol }}</td>  --}}
                                            <td style="font-weight: 800"> &nbsp;&nbsp; {{ $total }}</td>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('.addOrder').on('click', function() {
                var id = $(this).val();
                $.ajax({
                    url: '-add/' + id,
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function() {
                        console.log("Order Delivery Assigned");
                    }
                });
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
@endsection
