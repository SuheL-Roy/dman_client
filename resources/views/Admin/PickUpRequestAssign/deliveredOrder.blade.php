@extends('Master.main')
@section('title')
    Delivered Order
@endsection
@section('content')
    <div class="data-table-area mg-tb-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1 class="col-lg-9" style="padding:0px;">
                                    Order List <small> ( Delivered Order ) </small>
                                </h1>
                                <div class="container col-lg-3">
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
                        <form class="" method="post" action="{{ route('request.assign.confirm.invoice') }}">
                            @csrf
                            <p id="text" style="display: none;">
                            <button type="submit" class="btn btn-success col-lg-1" style="float:right;"
                                onclick="return confirm('Are You Sure ?')">Confirm
                            </button>
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
                                                <th> <input type="checkbox" class="selectall"></th>

                                                <th data-field="sl">SL.</th>
                                                <th data-field="tracking_id" data-editable="false">Tracking ID</th>

                                                <th data-field="business_name" data-editable="false">Merchant Name</th>
                                                <th data-field="ees" data-editable="false">Merchant Phone</th>
                                                {{-- <th data-field="shop_name" data-editable="false">S. Name</th>
                                                <th data-field="shop_phone" data-editable="false">S. Phone</th>
                                                <th data-field="shop_area" data-editable="false">S. Address</th> --}}
                                                <th data-field="customer_name" data-editable="false">Customer Name</th>
                                                <th data-field="customer_phone" data-editable="false">Customer Phone</th>
                                                <th data-field="customer_address" data-editable="false">Customer Address
                                                </th>

                                                <th data-field="collection" data-editable="false">Invoice Value</th>
                                              {{--  <th data-field="e" data-editable="false">type</th> --}}
                                                <th data-field="collected">Collected</th>
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
                                                    <td>{{ $data->mobile }}</td>
                                                    {{-- <td>{{ $data->shop }}</td>
                                                    <td>{{ $data->shop_phone }}</td>
                                                    <td>{{ $data->shop_area }}</td> --}}
                                                    <td>{{ $data->customer_name }}</td>
                                                    <td>{{ $data->customer_phone }}</td>
                                                    <td>{{ $data->customer_address }}</td>
                                                    <td>{{ $data->collection }}</td>
                                                   {{-- <td>{{ $data->type=='Urgent'?'One Hour':'Regular' }}</td> --}}
                                                    <td>{{ $data->collect }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9" style="text-align:right;"> <span
                                                        style="color: rgb(242, 1, 255) ; font-size:25px "><b>Total :</b>
                                                    </span> &nbsp;</td>
                                                <td tyle="text-align:right"> <span
                                                        style="font-size:25px; color: rgb(242, 1, 255)">
                                                        &nbsp;&nbsp;
                                                        <span> <b>{{ $total }}</b> </span>
                                                </td>
                                            </tr>
                                        </tfoot>

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
            // $(".selectall").click(function() {
            //     var checked = this.checked;
            //     if (checked == true) {
            //         $('.select_id').prop('checked', true);
            //     } else {
            //         $('.select_id').prop('checked', false);
            //     }
            // });
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
