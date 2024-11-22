@extends('Master.main')
@section('title')
    Return To Merchant
@endsection
@section('content')

<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 class="col-lg-4" style="padding:0px;">
                                Order List <small> ( Return To Merchant ) </small>
                            </h1>
                            <div class="container col-lg-5">
                                @if(session('message'))
                                <div class="alert alert-dismissible alert-info"
                                    style="padding-top:5px; padding-bottom:5px; 
                                        margin-top:0px; margin-bottom:0px; text-align:center;">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ session('message') }}</strong>
                                </div>  
                                @endif
                            </div>
                            <a href="{{ route('order.return.rider.confirm') }}" style="float:right;"
                                class="btn btn-primary col-lg-2 Primary">Return Assign
                            </a>
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
                            <table id="table" data-toggle="table" data-pagination="true" 
                                    data-search="true" data-show-columns="true" 
                                    data-show-pagination-switch="true" data-show-refresh="true" 
                                    data-key-events="true" data-show-toggle="true" 
                                    data-resizable="true" data-cookie="true"
                                    data-cookie-id-table="saveId" data-show-export="true" 
                                    data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="sl">SL.</th>
                                        <th data-field="tracking_id" data-editable="false">Tracking ID</th>
                                        <th data-field="order_id" data-editable="false">Order ID</th>
                                        <th data-field="merchant" data-editable="false">Merchant</th>
                                        <th data-field="mobile" data-editable="false">Mobile</th>
                                        <th data-field="area" data-editable="false">Area</th>
                                        <th data-field="status" data-editable="false">Status</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;?>
                                    @foreach ($order as $data)
                                    <tr>
                                        <td></td>
                                        <td>{{ $i++ }}.</td>
                                        <td>{{ $data->tracking_id }}</td>
                                        <td>{{ $data->order_id }}</td>
                                        <td>{{ $data->merchant }}</td>
                                        <td>{{ $data->mobile }}</td>
                                        <td>{{ $data->area }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td class="datatable-ct">
                                            <button class="addOrder btn btn-primary btn-xs" 
                                                value="{{ $data->tracking_id }}" type="button">
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.addOrder').on('click', function () {
            var id = $(this).val();
            $.ajax(
            {
                url: 'rider-add/' +id,
                type: 'GET',
                data: { id : id },
                success: function ()
                {
                    console.log("Order Return To Merchant Assigned Rider. ");
                }
            });
        });
    });
</script>

@endsection