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
                                <h1 class="col-lg-2" style="padding:0px; margin-right:20px;">
                                    Rider Order History
                                </h1>

                                <form action="{{ route('order.report.delivery.rider') }}" method="GET">
                                    @csrf
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label style="float:right;">Status</label>
                                            </div>
                                            <div class="col-lg-7">
                                                <select name="status" class="form-control" required>
                                                    <option> ---select status--- </option>
                                                    <option value="Pickup Done"
                                                        {{ $orderStatus === 'Pickup Done' ? 'selected' : '' }}>
                                                        Pickup Done
                                                    </option>
                                                    <option value="Successfully Delivered"
                                                        {{ $orderStatus === 'Successfully Delivered' ? 'selected' : '' }}>
                                                        Successfully Delivered
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3" style="padding:0px;">
                                                <label style="float:right;">From :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" name="fromdate" value="{{ $fromdate }}"
                                                    class="form-control"
                                                    class="@error('fromdate') border:1px solid red @enderror" />
                                            </div>
                                            @error('fromdate')
                                                <span style="color: red" class="invalid-feedback"
                                                    role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-2" style="padding:0px;">
                                                <label style="float:right;">To :</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="date" value="{{ $todate }}" class="form-control"
                                                    name="todate" required />
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit"class="btn btn-primary btn-sm Primary">Load</button>
                                </form>
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
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                                <th data-field="pickup_date" data-editable="false">Pickup Date</th>

                                                <th data-field="merchant_name" data-editable="false">Merchant Name</th>
                                                <th data-field="c_name" data-editable="false">Customer Name</th>
                                                <th data-field="c_phone" data-editable="false">Customer Phone</th>
                                                <th data-field="c_address" data-editable="false">Customer Address</th>

                                                <th data-field="invoice_value" data-editable="false">Invoice Value</th>
                                                <th data-field="type" data-editable="false">Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            @foreach ($order as $data)
                                                <tr>
                                                    <td><input id="trackings" type="checkbox" class="select_id"
                                                            value="{{ $data->tracking_id }}" name="tracking_ids[]" />
                                                    </td>

                                                    <td>{{ $i++ }}.</td>
                                                    <td>{{ $data->tracking_id }}</td>
                                                    <td> {{ $data->created_at->format('d-m-Y') }} </td>
                                                    <td> {{ $data->business_name }} </td>
                                                    <td> {{ $data->customer_name }} </td>
                                                    <td> {{ $data->customer_phone }} </td>
                                                    <td> {{ $data->customer_address }} </td>
                                                    <td> {{ $data->colection }} </td>
                                                    <td> {{ $data->type }} </td>

                                                    {{-- <td></td> --}}

                                                    {{-- <td class="datatable-ct"> --}}





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
