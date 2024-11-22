@extends('Master.main') @section('title')
    Pick Up Requests
    @endsection @section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-5" style="padding: 0px;">Pick Up Order List <small> </small></h1>

                                <div class="container col-lg-4">
                                    @if (session('message'))
                                        <div class="text-center alert alert-dismissible alert-info"
                                            style="padding-top: 5px; padding-bottom: 5px; margin-top: 0px; margin-bottom: 0px;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>{{ session('message') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <form class="" method="post" action="{{ route('request.assign.list.load') }}">
                                        @csrf

                                        <div class="col-lg-4">
                                            <select name="user_id" class="form-control status" required>
                                                <option value="">---select Merchant ---</option>
                                                @foreach ($merchants as $merchant)
                                                    <option value="{{ $merchant->user_id }}"
                                                        {{ $selectedMerchant == $merchant->user_id ? 'Selected' : '' }}>
                                                        {{ $merchant->business_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button type="submit" class="col-lg-2 btn btn-info btn-sm">
                                            Load
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <form action="{{ route('request.assign.collect.all') }}" method="GET">
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
                                        data-key-events="true" data-show-toggle="true" data-resizable="true"
                                        data-cookie="true" data-cookie-id-table="saveId" data-show-export="true"
                                        data-click-to-select="true" data-toolbar="#toolbar">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="selectall" /></th>
                                                <th data-field="sl">SL.</th>
                                                <th data-field="pickup_date" data-editable="false">Create Date</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>

                                                {{-- <th data-field="pickup_date" data-editable="false">Pickup Date</th> --}}
                                                {{-- <th data-field="pickup_time" data-editable="false">Pickup Time</th> --}}

                                                <th data-field="merchant_name" data-editable="false">Merchant Name</th>
                                                {{-- <th data-field="s_name" data-editable="false">Merchant Name</th> --}}
                                                <th data-field="s_phone" data-editable="false">Merchant Phone</th>
                                                <th data-field="s_address" data-editable="false">Merchant Address</th>
                                                <th data-field="shop" data-editable="false">Customer Name</th>
                                                <th data-field="shop2" data-editable="false">Customer Phone</th>
                                                <th data-field="shop3" data-editable="false">Customer Address</th>

                                                {{-- <th data-field="status" data-editable="false">Status</th>
                                                <th data-field="area" data-editable="false">Type</th> --}}
                                                <th data-field="action">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($order as $data)
                                                <tr>
                                                    <td><input id="trackings" type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" /></td>

                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->created_at }}</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    {{-- <td>{{ $data->pickup_date ?? 'Not Found' }}</td>
                                                    <td>{{ $data->pickup_time ?? 'No Found' }}</td> --}}
                                                    <td>{{ $data->business_name }}</td>

                                                    {{-- <td>{{ $data->shop_name }}</td> --}}
                                                    <td>{{ $data->mobile }}</td>
                                                    <td>{{ $data->address }}</td>
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    {{-- <td> {{ $data->shop }} </td>
                                                    <td>{{ $data->status }}</td>

                                                    <td>{{ $data->type == 'Urgent' ? 'One Hour' : 'Regular' }}</td> --}}

                                                    <td class="datatable-ct">


                                                        <a href="{{ route('request.assign.collect', ['id' => $data->tracking_id]) }}"
                                                            class="btn btn-success"
                                                            onclick="return confirm('Are You Sure You Want To Change Status ??')"
                                                            title="Order Collect ??">
                                                            <i class="fa fa-arrow-up"></i>
                                                            COLLECT
                                                            {{-- <button class="btn btn-success"> COLLECT</button> --}}
                                                        </a>
                                                        {{-- <a href="{{ route('request.assign.cancel', ['id' => $data->tracking_id]) }}" class="btn btn-danger" onclick="return confirm('Are You Sure You Want To Change Status ??')" title="PickUp Cancel ??">
                                                    <i class="fa fa-close"></i> Cancel
                                                    
                                                </a> --}}


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

    <script>
        $(document).ready(function() {
            $(".ediT").on("click", function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('request.assign.edit') }}",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        $(".id").val(data[0]["tracking_id"]);
                    },
                });
            });
            $("#updatE").on("submit", function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('request.assign.update') }}",
                    data: {
                        _token: $("input[name=_token]").val(),
                        tracking_id: $(".id").val(),
                        rider: $(".rider").val(),
                    },
                    success: function() {
                        $("#InformationproModalhdbgcl").modal("hide");
                        location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                        alert("Data Not Saved");
                    },
                });
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
