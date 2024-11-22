@extends('Master.main')
@section('title')
    Merchant Order Status
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <div class="row">
                                    <h1 class="col-lg-3">
                                        Order Status <small>( Merchant Wise )</small>
                                    </h1>
                                    <form class="col-lg-8" action="{{ route('order.status.merchant') }}" method="get">@csrf
                                        <div class="row">
                                            <div class="col-lg-3" style="padding:0px;">
                                                <select name="merchant" class="selectpicker form-control"
                                                    title="Select Merchant" data-style="btn-info" required
                                                    data-live-search="true" style="margin:0px; padding-left:5px;">
                                                    {{--  <option value="">Select Merchant</option>  --}}
                                                    @foreach ($user as $data)
                                                        <option value="{{ $data->id }}">{{ $data->business_name }} -
                                                            (M{{ $data->id }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <label style="float:right;">From:</label>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <input type="date" name="fromdate" required
                                                            value="{{ $fromdate }}" class="form-control"
                                                            style="padding-left: 7px;" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label style="float:right;">To:</label>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <input type="date" value="{{ $todate }}"
                                                            class="form-control" name="todate" required />
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        Load
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('order.status.merchant.print') }}" method="get"
                                        class="col-lg-1" style="float: right;" target="_blank" name="Mer">@csrf
                                        <input type="hidden" name="merchant" value="{{ $merchant }}" />
                                        <input type="hidden" name="fromdate" value="{{ $fromdate }}" />
                                        <input type="hidden" name="todate" value="{{ $todate }}" />
                                        <button type="submit" class="btn btn-primary btn-sm" style="float: right;">
                                            <i class="fa fa-print"></i>
                                        </button>
                                    </form>
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
                                            <th data-field="order_id" data-editable="false">Order ID</th>
                                            <th data-field="merchant" data-editable="false">Merchant</th>
                                            <th data-field="pickup_date" data-editable="false">Pick Up Date</th>
                                            <th data-field="collection" data-editable="false">Collection</th>
                                            <th data-field="merchant_pay" data-editable="false">Merchant Pay</th>
                                            <th data-field="status" data-editable="false">Status</th>
                                            <th data-field="created_at" data-editable="false">Created At</th>
                                            {{--  <th data-field="action">Action</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($order as $data)
                                            <tr>
                                                <td></td>
                                                <td>{{ $i++ }}.</td>
                                                <td>{{ $data->tracking_id }}</td>
                                                <td>{{ $data->order_id }}</td>
                                                <td>{{ $data->merchant }}</td>
                                                <td>{{ $data->pickup_date }}</td>
                                                <td>{{ $data->collection }}</td>
                                                <td>{{ $data->merchant_pay }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>{{ $data->created_at }}</td>
                                                {{--  <td class="datatable-ct">
                                            @can('admin')
                                            <button class="btn btn-danger deletE btn-xs"
                                                data-id="{{ $data->id }}">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                            @endcan
                                            @if ($data->status == '1')
                                                <a href="{{route('category.status',['id'=>$data->id])}}" 
                                                    class="btn btn-warning btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Category Status ??')">
                                                    <i class="fa fa-arrow-down" 
                                                    title="Change Category Status to Inactive ??"></i>
                                                </a>
                                            @elseif($data->status == "0")
                                                <a href="{{route('category.status',['id'=>$data->id])}}" 
                                                    class="btn btn-success btn-xs"
                                                    onclick="return confirm('Are You Sure You Want To Change Category Status ??')">
                                                    <i class="fa fa-arrow-up" 
                                                    title="Change Category Status to Active ??"></i>
                                                </a>
                                            @endif
                                        </td>  --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="9" style="text-align:right;">Total Order :</td>
                                            <td style="text-align:left;"> &nbsp; {{ $Qty }}</td>
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
            $('.ediT').on('click', function() {
                var id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('category.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.name').val(data[0]['name']);
                    }
                });
            });
            $('#updatE').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('category.update') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $(".id").val(),
                        'name': $(".name").val(),
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
        $('.deletE').on('click', function() {
            var id = $(this).data("id");
            $.ajax({
                url: "{{ route('category.destroy') }}",
                type: 'GET',
                data: {
                    "id": id
                },
                success: function() {
                    console.log("Data Deleted Successfully");
                    location.reload();
                }
            });
        });
    </script>
    <script>
        document.forms['Mer'].elements['merchant'].value = '{{ $merchant }}';
    </script>
@endsection
